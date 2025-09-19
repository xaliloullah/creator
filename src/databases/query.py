from src.databases.database import Database 
from src.databases.connections.connector import Connector

class Query:
    def __init__(self, script="", values=()):  
        self.script = script
        self.values = values
        self.conditions = "" 
        self.placeholder = Connector.database().placeholder 
        
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

    def create(self, table, columns):  
        self.values = ()
        self.script = f"CREATE TABLE IF NOT EXISTS {table} ({columns})" 
        return self
    
    def alter(self, table, definition:str): 
        self.values = ()
        self.script = f"ALTER TABLE {table} {definition}"
        return self 

    def drop(self, table, if_exists=True):
        self.values = ()
        self.script = f"DROP TABLE IF EXISTS {table}"
        return self
    
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
    
    def where(self, **kwargs):
        self.conditions = ' AND '.join([f'{key}={self.placeholder}' for key in kwargs.keys()])
        self.values += tuple(kwargs.values())
        if 'WHERE' in self.script:
            self.script = f"{self.script} AND {self.conditions}"
        else:
            self.script = f"{self.script} WHERE {self.conditions}"
        return self
    
    def where_not(self, **kwargs):
        self.conditions = ' AND '.join([f'{key}!={self.placeholder}' for key in kwargs.keys()])
        self.values += tuple(kwargs.values())
        if 'WHERE' in self.script:
            self.script = f"{self.script} AND {self.conditions}"
        else:
            self.script = f"{self.script} WHERE {self.conditions}" 
        return self
    
    def like(self, **kwargs):
        self.conditions = ' AND '.join([f'{key} LIKE {self.placeholder}' for key in kwargs.keys()])
        self.values += tuple(f"%{value}%" for value in kwargs.values())
        if 'WHERE' in self.script:
            self.script = f"{self.script} AND {self.conditions}"
        else:
            self.script = f"{self.script} WHERE {self.conditions}" 
        return self
    
    def or_where(self, **kwargs):
        self.conditions = ' OR '.join([f'{key}={self.placeholder}' for key in kwargs.keys()])
        self.values += tuple(kwargs.values())
        if 'WHERE' in self.script:
            self.script = f"{self.script} OR {self.conditions}"
        else:
            self.script = f"{self.script} WHERE {self.conditions}" 
        return self
    
    def where_null(self, column):
        if 'WHERE' in self.script:
            self.script = f"{self.script} AND {column} IS NULL"
        else:
            self.script = f"{self.script} WHERE {column} IS NULL"
        return self

    def where_not_null(self, column):
        if 'WHERE' in self.script:
            self.script = f"{self.script} AND {column} IS NOT NULL"
        else:
            self.script = f"{self.script} WHERE {column} IS NOT NULL"
        return self

    def clause(self, clause='IN', **kwargs):
        for column, values in kwargs.items():
            if not isinstance(values, (list, tuple)) or not values:
                continue
            placeholders = ', '.join([self.placeholder for _ in values])
            condition = f"{column} {clause} ({placeholders})"
            if 'WHERE' in self.script:
                self.script = f"{self.script} AND {condition}"
            else:
                self.script = f"{self.script} WHERE {condition}"
            self.values += tuple(values)
        return self
    
    def or_clause(self, clause='IN', **kwargs):
        for column, values in kwargs.items():
            if not isinstance(values, (list, tuple)) or not values:
                continue
            placeholders = ', '.join([self.placeholder for _ in values])
            condition = f"{column} {clause} ({placeholders})"
            if 'WHERE' in self.script:
                self.script = f"{self.script} OR {condition}"
            else:
                self.script = f"{self.script} WHERE {condition}"
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

    def raw(self, script, *values):
        self.script = script
        self.values = values
        return self
    
    def subquery(self, subquery_script, alias):
        self.script = f"({subquery_script}) AS {alias}"
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
    
    def join(self, table, option=""):
        self.script = f"{self.script} {option} JOIN {table}"  
        return self
    
    def on(self, **kwargs): 
        self.conditions = [f"{key} = {value}" for key, value in kwargs.items()] 
        conditions_str = ' AND '.join(self.conditions) 
        self.script = f"{self.script} ON {conditions_str}" 
        return self
    
    def count(self, column='*'):
        self.script = f"SELECT COUNT({column}) FROM ({self.script}) AS alias" 
        return self
    
    def first(self):  
        self.order_by().limit(1) 
        return self
    
    def last(self):  
        self.order_by(option="DESC").limit(1) 
        return self 
    
    def generate(self, reset=True): 
        result = (self.script, self.values or None)
        if reset:
            self.reset()
        return result
    
    def reset(self):
        self.script=""
        self.values=() 
        self.conditions=""

    def debug(self):
        sql = self.script
        for value in self.values:
            sql = sql.replace(self.placeholder, repr(value), 1)
        return sql
        
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
 