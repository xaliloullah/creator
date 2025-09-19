class RDBMS:
    """Generic base class for database connectors."""
    placeholder ='?'
    syntax = { 
        'ID' : 'INTEGER',
        'UUID' : 'TEXT',
        'VARCHAR': 'TEXT',          
        'BIGINT': 'INTEGER',        
        'INT': 'INTEGER',           
        'SMALLINT': 'INTEGER',
        'MEDIUMINT': 'INTEGER',    
        'CHAR': 'TEXT',          
        'FLOAT': 'REAL',       
        'DATE': 'TEXT',            
        'DECIMAL': 'INTEGER',   
        'DOUBLE': 'REAL',      
        'TINYTEXT': 'TEXT',      
        'TINYINT': 'INTEGER',      
        'VARBINARY': 'BLOB',   
        'BINARY': 'BLOB',         
        'BLOB': 'BLOB',   
        'ENUM': 'TEXT',            
        'TEXT': 'TEXT', 
        'JSON': 'TEXT',            
        'BIT': 'INTEGER',           
        'BOOLEAN': 'INTEGER',       
        'DATETIME': 'TEXT',         
        'NUMERIC': 'INTEGER',            
        'TIME': 'TEXT',
        'AUTO_INCREMENT':'AUTOINCREMENT',   
        'FOREIGN_KEY': 'FOREIGN KEY',        
        'PRIMARY_KEY': 'PRIMARY KEY',       
        'REFERENCES': 'REFERENCES',   
        'DEFAULT': 'DEFAULT',  
        'NOT_NULL': 'NOT NULL',                   
        'NULL': 'NULL',                   
        'UNIQUE': 'UNIQUE',                        
        'SET_NULL': 'SET NULL',
        'CHECK': 'CHECK',
        'COMMENT': 'COMMENT',  
        'TIMESTAMP': 'TIMESTAMP',   
        'UNSIGNED': '',      
        # 
        'ADD_COLUMN':'',
        'MODIFY_COLUMN': '',
        'CHANGE': '',
        'DROP_COLUMN': '',
        'RENAME_COLUMN': '',
        'VERSION': ''   
    }
    
    def __init__(self, config):
        self.connection = None
        self.cursor = None
        self.config = config 
        self.master = '' 

    # def connect(self):
    #     """Establish the database connection."""
    #     raise NotImplementedError("The 'connect' method must be implemented in the child class.")

    def execute(self, query, params=None):
        """Execute a SQL query."""
        raise NotImplementedError("The 'execute' method must be implemented in the child class.")

    # def fetchall(self):
    #     """Fetch all rows from the last executed query."""
    #     raise NotImplementedError("The 'fetchall' method must be implemented in the child class.")

    # def fetchone(self):
    #     """Fetch a single row from the last executed query."""
    #     raise NotImplementedError("The 'fetchone' method must be implemented in the child class.")

    # def close(self):
    #     """Close the cursor and connection."""
    #     raise NotImplementedError("The 'close' method must be implemented in the child class.")
