from src.databases.database import Database 
from src.databases.connections.connector import Connector

class Query:
    def __init__(self, script="", values=()):  
        self.script = script
        self.values = values
        self.conditions = "" 
        self.placeholder = Connector.database().placeholder 

    # --- Execution Methods ---    
    def get(self): 
        return self.generate(reset=False)
    
    def execute(self):
        Database().execute(*self.generate())    

    def fetchall(self):
        return Database().fetchall(*self.generate()) 

    def fetchone(self):
        return Database().fetchone(*self.generate()) 
    
    def transaction(self):
        Database().transaction()
        return self
    
    def commit(self):
        Database().commit()
        return self
    
    def rollback(self):
        Database().rollback()
        return self 

    # --- DDL Methods ---
    def create(self, table, columns, if_not_exists=True):  
        self.values = ()
        self.script = f"CREATE TABLE {"IF NOT EXISTS " if if_not_exists else ""}{table} ({columns})" 
        return self
    
    def alter(self, table, definition:str): 
        self.values = ()
        self.script = f"ALTER TABLE {table} {definition}"
        return self 

    def drop(self, table, if_exists=True):
        self.values = () 
        self.script = f"DROP TABLE {"IF EXISTS " if if_exists else ""}{table}"
        return self
    
    # --- DML Methods ---
    def insert(self, table, **kwargs):
        columns = ', '.join(kwargs.keys())
        self.values = tuple(kwargs.values())
        placeholders = ', '.join([f'{self.placeholder}' for _ in kwargs.keys()])
        self.script = f"INSERT INTO {table} ({columns}) VALUES ({placeholders})"  
        return self
    
    def update(self, table, **kwargs): 
        columns = ', '.join([f'{key}={self.placeholder}' for key in kwargs.keys()])
        self.values = tuple(kwargs.values())
        # if add_timestamp:
        # columns += ', updated_at=CURRENT_TIMESTAMP'
        self.script = f"UPDATE {table} SET {columns}"
        return self 
    
    def delete(self, table): 
        self.values = ()
        self.script = f"DELETE FROM {table}" 
        return self
    
    def select(self, table, *columns):
        self.values = ()
        if not columns:
            columns = ['*'] 
        columns = ', '.join(columns)
        self.script = f"SELECT {columns} FROM {table}"  
        return self
    
    # --- Condition Methods ---
    def where(self, **kwargs):
        self.conditions = ' AND '.join([f'{key}={self.placeholder}' for key in kwargs.keys()])
        self.values += tuple(kwargs.values())
        self._add_condition(self.conditions, "AND") 
        return self
    
    def where_not(self, **kwargs):
        self.conditions = ' AND '.join([f'{key}!={self.placeholder}' for key in kwargs.keys()])
        self.values += tuple(kwargs.values())
        self._add_condition(self.conditions, "AND")
        return self
    
    def or_where(self, **kwargs):
        self.conditions = ' OR '.join([f'{key}={self.placeholder}' for key in kwargs.keys()])
        self.values += tuple(kwargs.values())
        self._add_condition(self.conditions, "OR")
        return self
    
    def where_null(self, column):
        self._add_condition(f"{column} IS NULL", "AND") 
        return self

    def where_not_null(self, column):
        self._add_condition(f"{column} IS NOT NULL", "AND")  
        return self
    
    def like(self, **kwargs):
        self.conditions = ' AND '.join([f'{key} LIKE {self.placeholder}' for key in kwargs.keys()])
        self.values += tuple(f"%{value}%" for value in kwargs.values())
        self._add_condition(self.conditions, "AND")
        return self
    
    def between(self, column, start, end):
        self._add_condition(f"{column} BETWEEN {self.placeholder} AND {self.placeholder}", "AND")
        self.values += (start, end)
        return self

    def not_between(self, column, start, end):
        self._add_condition(f"{column} NOT BETWEEN {self.placeholder} AND {self.placeholder}", "AND")
        self.values += (start, end)
        return self
    
    def exists(self):
        return self.subquery(f"EXISTS", alias="exists_alias", with_from=False)
    
    def not_exists(self):
        return self.subquery(f"NOT EXISTS", alias="exists_alias", with_from=False)

    def raw(self, script, values=(), prefix=False): 
        if prefix:
            self.script = f"{script} {self.script}"
        else:
            self.script += f" {script}"
        if values:
            self.values += tuple(values)
        
        return self

    def union(self, subquery):
        self.script = f"{self.script} UNION {subquery.script}"
        self.values += subquery.values
        return self

    # def union_all(self): 
    #     self.script = f"{self.script} UNION ALL {subquery.script}"
    #     self.values += subquery.values
    #     return self

    def clause(self, clause='IN', **kwargs):
        for column, values in kwargs.items():
            if not isinstance(values, (list, tuple)) or not values:
                continue
            placeholders = ', '.join([self.placeholder for _ in values])
            condition = f"{column} {clause} ({placeholders})"
            self._add_condition(condition, "AND")
            self.values += tuple(values)
        return self
    
    def or_clause(self, clause='IN', **kwargs):
        for column, values in kwargs.items():
            if not isinstance(values, (list, tuple)) or not values:
                continue
            placeholders = ', '.join([self.placeholder for _ in values])
            condition = f"{column} {clause} ({placeholders})"
            self._add_condition(condition, "OR")
            self.values += tuple(values)
        return self
    
    def having(self, **kwargs):
        self.conditions = ' AND '.join([f'{key}={self.placeholder}' for key in kwargs.keys()])
        self.script = f"{self.script} HAVING {self.conditions}"
        self.values += tuple(kwargs.values())
        return self
    
    def group_by(self, *columns):
        cols = ', '.join(columns)
        self.script = f"{self.script} GROUP BY {cols}"
        return self 
    
    def paginate(self, page, per_page):
        offset = (page - 1) * per_page
        self.script = f"{self.script} LIMIT {per_page} OFFSET {offset}" 
        return self
    
    def order_by(self, column='id', option='ASC'):
        self.script = f"{self.script} ORDER BY {column} {option}" 
        return self
    
    def limit(self, value):
        self.script = f"{self.script} LIMIT {value}" 
        return self
    
    def alias(self, alias):
        self.script = f"{self.script} AS {alias}"  
        return self
    
    def join(self, table, type="INNER"):
        self.script = f"{self.script} {type.upper()} JOIN {table}"  
        return self
    
    def left_join(self, table):
        return self.join(table, "LEFT")

    def right_join(self, table):
        return self.join(table, "RIGHT")

    def full_join(self, table):
        return self.join(table, "FULL")
    
    def on(self, **kwargs): 
        conditions = [f"{k}={self.placeholder}" for k in kwargs.keys()]
        self.script = f"{self.script} ON {' AND '.join(conditions)}"
        self.values += tuple(kwargs.values())
        return self
    
    def subquery(self, query, alias="subquery", with_from=True):   
        self.script = f"SELECT {query} {"FROM " if with_from else ""}({self.script})"
        self.alias(alias) 
        return self
    
    def count(self, column='*'):
        return self.subquery(f"COUNT({column})", alias="count_alias")
    
    def first(self):  
        self.order_by().limit(1) 
        return self
    
    def last(self):  
        self.order_by(option="DESC").limit(1) 
        return self 
    
    # --- Generate / Reset ---
    def generate(self, reset=True): 
        result = (self.script, self.values or None)
        if reset:
            self.reset() 
        return result
    
    def reset(self):
        self.script=""
        self.values=() 
        self.conditions=""

    def resolve(self):
        sql = self.script
        for value in self.values:
            sql = sql.replace(self.placeholder, repr(value), 1)
        return sql
        
    # --- Utility Methods ---
    def _add_condition(self, condition, operator="AND"):
        if 'WHERE' in self.script:
            self.script = f"{self.script} {operator} {condition}"
        else:
            self.script = f"{self.script} WHERE {condition}"

    # --- Dunder Methods ---
    def __str__(self):
        return f"{self.script}, {self.values}" if self.values else f"{self.script}"
    
    def __repr__(self):
        return self.script
    
    def __call__(self, script, values):
        return Query(script, values)  
    
    def __enter__(self):
        return self

    def __exit__(self, exc_type, exc_val, exc_tb):
        self.reset()
 