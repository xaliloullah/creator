from src.databases.database import Database 

class Query:
    def __init__(self, database=Database()): 
        self.database = database 
        self.script = ""
        self.values = ()
        self.conditions = ""
        self.attributes = "" 
        self.placeholder = self.database.connection.placeholder 
        
    def execute(self):
        self.database.execute(self.script, self.values) 

    def get(self):
        return self.database.fetchall(self.script, self.values)
    
    def fetchall(self):
        return self.database.fetchall(self.script, self.values)
    
    def fetchone(self):
        return self.database.fetchone(self.script, self.values)
    
    def transaction(self):
        self.database.transaction()
        return self
    
    def commit(self):
        self.database.commit()
        return self
    
    def rollback(self):
        self.database.rollback()
        return self

    def create(self, table, columns, if_not_exists=True, engine="InnoDB", charset="utf8mb4"):  
        self.values = ()
        self.script = f'''CREATE TABLE IF NOT EXISTS {table} ({columns})''' 
        return self
        
    def drop(self, table, if_exists=True):
        self.values = ()
        self.script = f'''DROP TABLE IF EXISTS {table}'''
        return self
    
    def insert(self, table, **kwargs):
        columns = ', '.join(kwargs.keys())
        self.values = tuple(kwargs.values())
        placeholders = ', '.join([f'{self.placeholder}' for _ in kwargs.keys()])
        self.script = f'''INSERT INTO {table} ({columns}) VALUES ({placeholders})'''  
        return self
    
    def update(self, table, **kwargs): 
        columns = ', '.join([f'{key}={self.placeholder}' for key in kwargs.keys()])
        self.values = tuple(kwargs.values())
        # if add_timestamp:
        columns += ', updated_at=CURRENT_TIMESTAMP'
        self.script = f'''UPDATE {table} SET {columns}'''
        return self 
    
    def delete(self, table): 
        self.values = ()
        self.script = f'''DELETE FROM {table}''' 
        return self
    
    def select(self, table, *columns):
        self.values = ()
        if not columns:
            columns = ['*'] 
        columns = ', '.join(columns)
        self.script = f'''SELECT {columns} FROM {table}'''  
        return self
    
    def where(self, **kwargs):
        self.conditions = ' AND '.join([f'{key}={self.placeholder}' for key in kwargs.keys()])
        self.values += tuple(kwargs.values())
        if 'WHERE' in self.script:
            self.script = f'''{self.script} AND {self.conditions}'''
        else:
            self.script = f'''{self.script} WHERE {self.conditions}'''
        return self
    
    def where_not(self, **kwargs):
        self.conditions = ' AND '.join([f'{key}!={self.placeholder}' for key in kwargs.keys()])
        self.values += tuple(kwargs.values())
        if 'WHERE' in self.script:
            self.script = f'''{self.script} AND {self.conditions}'''
        else:
            self.script = f'''{self.script} WHERE {self.conditions}''' 
        return self
    
    def like(self, **kwargs):
        self.conditions = ' AND '.join([f'{key} LIKE {self.placeholder}' for key in kwargs.keys()])
        self.values += tuple(f"%{value}%" for value in kwargs.values())
        if 'WHERE' in self.script:
            self.script = f'''{self.script} AND {self.conditions}'''
        else:
            self.script = f'''{self.script} WHERE {self.conditions}''' 
        return self
    
    def or_where(self, **kwargs):
        self.conditions = ' OR '.join([f'{key}={self.placeholder}' for key in kwargs.keys()])
        self.values += tuple(kwargs.values())
        if 'WHERE' in self.script:
            self.script = f'''{self.script} OR {self.conditions}'''
        else:
            self.script = f'''{self.script} WHERE {self.conditions}''' 
        return self
    
    def where_null(self, column):
        if 'WHERE' in self.script:
            self.script = f'''{self.script} AND {column} IS NULL'''
        else:
            self.script = f'''{self.script} WHERE {column} IS NULL'''
        return self

    def where_not_null(self, column):
        if 'WHERE' in self.script:
            self.script = f'''{self.script} AND {column} IS NOT NULL'''
        else:
            self.script = f'''{self.script} WHERE {column} IS NOT NULL'''
        return self

    def in_clause(self, column, values):
        placeholders = ', '.join([self.placeholder for _ in values])
        if 'WHERE' in self.script:
            self.script = f'''{self.script} AND {column} IN ({placeholders})'''
        else:
            self.script = f'''{self.script} WHERE {column} IN ({placeholders})'''
        self.values += tuple(values)
        return self
    
    def having(self, **kwargs):
        conditions = ' AND '.join([f'{key}={self.placeholder}' for key in kwargs.keys()])
        self.script = f'''{self.script} HAVING {conditions}'''
        self.values += tuple(kwargs.values())
        return self
    
    def group_by(self, *columns):
        cols = ', '.join(columns)
        self.script = f'''{self.script} GROUP BY {cols}'''
        return self

    
    def raw(self, script, *values):
        self.script = script
        self.values = values
        return self
    
    def subquery(self, subquery_script, alias):
        self.script = f'''({subquery_script}) AS {alias}'''
        return self
    
    def paginate(self, page, per_page):
        offset = (page - 1) * per_page
        self.script = f"{self.script} LIMIT {per_page} OFFSET {offset}" 
        return self
    
    def order_by(self, column='id', option='ASC'):
        self.script = f'''{self.script} ORDER BY {column} {option}''' 
        return self
    
    def limit(self, value):
        self.script = f'''{self.script} LIMIT {value}''' 
        return self
    
    def alias(self, alias):
        self.script = f'''{self.script} AS {alias}'''  
        return self
    
    def join(self, table, option=""):
        self.script = f'''{self.script} {option} JOIN {table}'''  
        return self
    
    def on(self, **kwargs): 
        self.conditions = [f"{key} = {value}" for key, value in kwargs.items()] 
        conditions_str = ' AND '.join(self.conditions) 
        self.script = f"{self.script} ON {conditions_str}" 
        return self
    
    def count(self, column='*'):
        self.script = f'''SELECT COUNT({column}) FROM ({self.script}) AS alias''' 
        return self
    
    def first(self):  
        self.order_by().limit(1) 
        return self
    
    def last(self):  
        self.order_by(option="DESC").limit(1) 
        return self
    
    def generate_script(self):
        return self.script, self.values
    
    def debug(self):
        script_with_values = self.script
        for value in self.values:
            script_with_values = script_with_values.replace(self.placeholder, repr(value), 1)
        return f"SQL Query: {script_with_values}"
    
    def generate_script(self):
        return self.script, self.values
    
    def reset_script(self):
        self.script=""
        self.values=() 
        
    def __str__(self):
        return f"{self.script}, {self.values}"
    
    def __repr__(self):
        return self.script
    
    def __call__(self):
        return self.database.fetchall(self.script, self.values) 
    
    def has_one(self, related_table, foreign_key, foreign_id):
        conditions = {f"{foreign_key}":f"{foreign_id}"}
        self.select(related_table).where(**conditions) 
        self.attributes = self.database.fetchone(self.script,self.values)
        return self

    def has_many(self, related_table, foreign_key, foreign_id): 
        conditions = {f"{foreign_key}":f"{foreign_id}"}
        self.select(related_table).where(**conditions) 
        self.attributes = self.database.fetchall(self.script, self.values)
        return self


    def belongs_to(self, related_table,table, foreign_key=None, foreign_id=None):
        query = f"""SELECT * FROM {related_table} WHERE id = (SELECT {foreign_key} FROM {table} WHERE id = ?)"""
        self.attributes = self.database.fetchall(query, (foreign_id,))    
        return self
 