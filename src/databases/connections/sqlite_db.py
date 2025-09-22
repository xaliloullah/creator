import sqlite3 
from .rdbms import RDBMS

class Sqlite(RDBMS):
    """SQLite-specific implementation of the database connector."""
    placeholder ='?'
    syntax = {
        # Customs
        'ID': 'INTEGER',  
        'UUID': 'TEXT',     

        # Types
        'BIGINT': 'INTEGER',
        'INT': 'INTEGER',
        'SMALLINT': 'INTEGER',
        'MEDIUMINT': 'INTEGER',
        'TINYINT': 'INTEGER',
        'FLOAT': 'REAL',
        'DOUBLE': 'REAL',
        'DECIMAL': 'NUMERIC',
        'NUMERIC': 'NUMERIC',
        'BIT': 'INTEGER',       # No BIT type, use INTEGER 0/1
        'BOOLEAN': 'INTEGER',   # No BOOLEAN type, use 0/1
        'UNSIGNED': 'NOT SUPPORTED',  # SQLite does not support UNSIGNED
        'CHAR': 'TEXT',
        'VARCHAR': 'TEXT',
        'TINYTEXT': 'TEXT',
        'TEXT': 'TEXT',
        'MEDIUMTEXT': 'TEXT',
        'LONGTEXT': 'TEXT',
        'BINARY': 'BLOB',
        'VARBINARY': 'BLOB',
        'BLOB': 'BLOB',
        'TINYBLOB': 'BLOB',
        'MEDIUMBLOB': 'BLOB',
        'LONGBLOB': 'BLOB',
        'ENUM': 'TEXT',          # SQLite does not support ENUM
        'SET': 'TEXT',           # SQLite does not support SET
        'JSON': 'TEXT',          # SQLite has JSON1 extension, but stored as TEXT
        'DATE': 'TEXT',          # Stored as ISO8601 string
        'DATETIME': 'TEXT',      # Stored as ISO8601 string
        'TIME': 'TEXT',          # Stored as ISO8601 string
        'TIMESTAMP': 'TEXT',     # Stored as ISO8601 string
        'YEAR': 'INTEGER',

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
        'ON_UPDATE': 'NOT SUPPORTED',  # SQLite does not support ON UPDATE in the same way
        'ON_DELETE': 'ON DELETE',
        'INDEX': 'CREATE INDEX',       # Indexes created separately
        'AUTO_INCREMENT': 'AUTOINCREMENT', # Works only with INTEGER PRIMARY KEY
        'COMMENT': 'NOT SUPPORTED',    # SQLite does not support column comments
        'CHARACTER_SET': 'NOT SUPPORTED',
        'COLLATE': 'COLLATE',

        # Operations
        'ADD': 'ADD',
        'ADD_COLUMN': 'ADD COLUMN',
        'MODIFY_COLUMN': 'NOT SUPPORTED',   # ALTER COLUMN not supported
        'CHANGE': 'NOT SUPPORTED',          # ALTER COLUMN not supported
        'DROP_COLUMN': 'NOT SUPPORTED',     # Cannot drop column directly
        'RENAME_COLUMN': 'RENAME COLUMN',
        'ADD_INDEX': 'CREATE INDEX',
        'DROP_INDEX': 'DROP INDEX',
        'ALTER_TABLE': 'ALTER TABLE',
        'RENAME_TABLE': 'ALTER TABLE RENAME TO',
        'DROP_TABLE': 'DROP TABLE',
        'CREATE_TABLE': 'CREATE TABLE',

        # Functions
        'VERSION': 'SELECT sqlite_version()'
    }

    def __init__(self, config): 
        try:
            self.connection = sqlite3.connect(config['path'])
            self.connection.row_factory = sqlite3.Row
            self.cursor = self.connection.cursor() 
            self.master = 'sqlite_master'
        except sqlite3.Error as e:
            raise Exception(e)
            
    def execute(self, query, params=None, autocommit=True):
        try: 
            if params:
                self.cursor.execute(query, params)
            else:
                self.cursor.execute(query)
            if autocommit:
                self.commit()
        except sqlite3.Error as e:
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
