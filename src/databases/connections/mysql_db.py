try:
    import mysql.connector
except: 
    raise ImportError("MySQL connector is not installed. Please install it using 'py creator install mysql-connector-python'")
    
from .rdbms import RDBMS

class MySQL(RDBMS):
    """MySQL-specific implementation of the database connector."""
    placeholder = '%s'
    syntax = {
        # Customs
        'ID': 'BIGINT(20)',
        'UUID': 'CHAR(36)', 

        # Types
        'BIGINT': 'BIGINT',
        'INT': 'INT',
        'SMALLINT': 'SMALLINT',
        'MEDIUMINT': 'MEDIUMINT',
        'TINYINT': 'TINYINT',
        'FLOAT': 'FLOAT',
        'DOUBLE': 'DOUBLE',
        'DECIMAL': 'DECIMAL',
        'NUMERIC': 'NUMERIC',
        'BIT': 'BIT',
        'BOOLEAN': 'BOOLEAN',
        'UNSIGNED': 'UNSIGNED', 
        'CHAR': 'CHAR',
        'VARCHAR': 'VARCHAR',
        'TINYTEXT': 'TINYTEXT',
        'TEXT': 'TEXT',
        'MEDIUMTEXT': 'MEDIUMTEXT',
        'LONGTEXT': 'LONGTEXT',
        'BINARY': 'BINARY',
        'VARBINARY': 'VARBINARY',
        'BLOB': 'BLOB',
        'TINYBLOB': 'TINYBLOB',
        'MEDIUMBLOB': 'MEDIUMBLOB',
        'LONGBLOB': 'LONGBLOB',
        'ENUM': 'ENUM',
        'SET': 'SET',
        'JSON': 'JSON',
        'DATE': 'DATE',
        'DATETIME': 'DATETIME',
        'TIME': 'TIME',
        'TIMESTAMP': 'TIMESTAMP',
        'YEAR': 'YEAR',

        # Constraints / Keys
        'PRIMARY_KEY': 'PRIMARY KEY',
        'FOREIGN_KEY': 'FOREIGN KEY',
        'REFERENCES': 'REFERENCES',
        'NOT_NULL': 'NOT NULL',
        'NULL': 'NULL',
        'UNIQUE': 'UNIQUE',
        'CHECK': 'CHECK',
        'DEFAULT': 'DEFAULT',
        'SET_NULL': 'SET NULL',
        'ON_UPDATE': 'ON UPDATE',
        'ON_DELETE': 'ON DELETE',
        'INDEX': 'INDEX', 
        'AUTO_INCREMENT': 'AUTO_INCREMENT',
        'COMMENT': 'COMMENT',
        'CHARACTER_SET': 'CHARACTER SET',
        'COLLATE': 'COLLATE',

        # Operations
        'ADD': 'ADD',
        'ADD_COLUMN': 'ADD COLUMN',
        'MODIFY_COLUMN': 'MODIFY COLUMN',
        'CHANGE': 'CHANGE',
        'DROP_COLUMN': 'DROP COLUMN',
        'RENAME_COLUMN': 'RENAME COLUMN',
        'ADD_INDEX': 'ADD INDEX',
        'DROP_INDEX': 'DROP INDEX',
        'ALTER_TABLE': 'ALTER TABLE',
        'RENAME_TABLE': 'RENAME TABLE',
        'DROP_TABLE': 'DROP TABLE',
        'CREATE_TABLE': 'CREATE TABLE',

        # Functions
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
            self.master = 'information_schema.tables'
            
        except mysql.connector.Error as e: 
            raise Exception(e)
            
    def execute(self, query, params=None, autocommit=True):
        try:
            self.connection.start_transaction() 
            if params:
                self.cursor.execute(query, params)
            else:
                self.cursor.execute(query)
            if autocommit:
                self.commit()
        except mysql.connector.Error as e:
            self.rollback()
            raise Exception(e) 
        
    def fetchall(self):
        return self.cursor.fetchall()
    
    def fetchone(self):
        return self.cursor.fetchone()

    def commit(self):
        return self.connection.commit()
    
    def rollback(self):
        self.connection.rollback()
        
    def close(self):
        if self.cursor:
            self.cursor.close()
        if self.connection:
            self.connection.close()
