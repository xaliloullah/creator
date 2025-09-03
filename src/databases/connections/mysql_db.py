try:
    import mysql.connector
except: 
    ImportError("MySQL connector is not installed. Please install it using 'py creator install mysql-connector-python'")
from .builder import DatabaseBuilder

class MySQL(DatabaseBuilder):
    """MySQL-specific implementation of the database connector."""
    syntax = {
        'ID' : 'BIGINT(20)',
        'UUID' : 'CHAR',
        'VARCHAR': 'VARCHAR',
        'BIGINT': 'BIGINT',
        'INT': 'INT',
        'SMALLINT': 'SMALLINT',
        'MEDIUMINT': 'MEDIUMINT',
        'CHAR': 'CHAR',
        'FLOAT': 'FLOAT',
        'DATE': 'DATE',
        'DECIMAL': 'DECIMAL',
        'DOUBLE': 'DOUBLE',
        'TINYTEXT': 'TINYTEXT',
        'TINYINT': 'TINYINT',
        'VARBINARY': 'VARBINARY',
        'BINARY': 'BINARY',
        'BLOB': 'BLOB',
        'ENUM': 'ENUM',
        'TEXT': 'TEXT',
        'JSON': 'JSON',
        'BIT': 'BIT',
        'BOOLEAN': 'BOOLEAN',
        'DATETIME': 'DATETIME', 
        'NUMERIC': 'NUMERIC', 
        'STRING': 'STRING',  
        'TIME': 'TIME',
        'AUTO_INCREMENT': 'AUTO_INCREMENT',
        'PRIMARY_KEY': 'PRIMARY KEY',   
        'FOREIGN_KEY': 'FOREIGN KEY',   
        'REFERENCES': 'REFERENCES',   
        'DEFAULT': 'DEFAULT',  
        'NOT_NULL': 'NOT NULL',                   
        'NULL': 'NULL',                   
        'UNIQUE': 'UNIQUE',                        
        'SET_NULL': 'SET NULL',
        'CHECK': 'CHECK',
        'COMMENT': 'COMMENT', 
        'TIMESTAMP': 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',  
        'UNSIGNED': 'UNSIGNED', 
        'ON_UPDATE': 'ON UPDATE', 
        'ON_DELETE': 'ON DELETE', 
    }
    def __init__(self, config):
        try:
            self.connection = mysql.connector.connect(
                host=config['host'],
                user=config['username'],
                password=config['password'],
                database=config['database']
            )
            self.cursor = self.connection.cursor(dictionary=True, buffered=True)  
            self.placeholder ='%s'
            self.master = 'mysql_master'
            
        except mysql.connector.Error as e: 
            raise Exception(e)
            
    def execute(self, query, params=None):
        try:
            self.connection.start_transaction() 
            if params:
                self.cursor.execute(query, params)
            else:
                self.cursor.execute(query)
            self.connection.commit()
        except mysql.connector.Error as e:
            self.connection.rollback()
            raise Exception(e) 