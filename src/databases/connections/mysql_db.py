try:
    import mysql.connector
except: 
    ImportError("MySQL connector is not installed. Please install it using 'py creator install mysql-connector-python'")
    
from .rdbms import RDBMS

class MySQL(RDBMS):
    """MySQL-specific implementation of the database connector."""
    placeholder = '%s'
    syntax = {
        'ID' : 'BIGINT(20)',
        'UUID' : 'VARCHAR',
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
        'TIMESTAMP': 'TIMESTAMP',  
        'UNSIGNED': 'UNSIGNED', 
        'ON_UPDATE': 'ON UPDATE', 
        'ON_DELETE': 'ON DELETE',
        'INDEX': 'INDEX',
        'CHARACTER_SET':'CHARACTER SET',
        # 
        'ADD_COLUMN':'ADD COLUMN',
        'MODIFY_COLUMN':'MODIFY COLUMN',
        'CHANGE': 'CHANGE',
        'DROP_COLUMN': 'DROP COLUMN',
        'RENAME_COLUMN': 'RENAME COLUMN',
        'VERSION': 'SELECT VERSION()'
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
        
    def fetchone(self):
        return self.cursor.fetchone()

    def fetchall(self):
        return self.cursor.fetchall()

        
    def close(self):
        if self.cursor:
            self.cursor.close()
        if self.connection:
            self.connection.close()
