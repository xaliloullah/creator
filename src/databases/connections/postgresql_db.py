try:    
    import psycopg2
    from psycopg2.extras import RealDictCursor
except: 
    raise ImportError("PostgreSQL connector is not installed. Please install it using 'py creator install psycopg2'")
from .rdbms import RDBMS

class PostgreSQL(RDBMS):
    """PostgreSQL-specific implementation of the database connector."""
    placeholder = '%s'
    syntax = {
        # Customs
        'ID': 'BIGSERIAL',       # BIGINT with auto-increment
        'UUID': 'UUID',

        # Types
        'BIGINT': 'BIGINT',
        'INT': 'INTEGER',
        'SMALLINT': 'SMALLINT',
        'MEDIUMINT': 'INTEGER',  # PostgreSQL has no MEDIUMINT, use INTEGER
        'TINYINT': 'SMALLINT',   # No TINYINT, use SMALLINT
        'FLOAT': 'REAL',
        'DOUBLE': 'DOUBLE PRECISION',
        'DECIMAL': 'DECIMAL',
        'NUMERIC': 'NUMERIC',
        'BIT': 'BIT',
        'BOOLEAN': 'BOOLEAN', 
        'CHAR': 'CHAR',
        'VARCHAR': 'VARCHAR',
        'TINYTEXT': 'TEXT',          # No TINYTEXT, use TEXT
        'TEXT': 'TEXT',
        'MEDIUMTEXT': 'TEXT',
        'LONGTEXT': 'TEXT',
        'BINARY': 'BYTEA',           # Binary data stored as BYTEA
        'VARBINARY': 'BYTEA',
        'BLOB': 'BYTEA',
        'TINYBLOB': 'BYTEA',
        'MEDIUMBLOB': 'BYTEA',
        'LONGBLOB': 'BYTEA',
        'ENUM': 'CREATE TYPE ... AS ENUM',  # Needs explicit type creation
        'SET': 'NOT SUPPORTED',       # PostgreSQL has no SET type
        'JSON': 'JSON',
        'DATE': 'DATE',
        'DATETIME': 'TIMESTAMP',     # PostgreSQL uses TIMESTAMP
        'TIME': 'TIME',
        'TIMESTAMP': 'TIMESTAMP',
        'YEAR': 'SMALLINT',          # No YEAR type, use SMALLINT or INT

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
        'ON_DELETE': 'ON DELETE',
        'INDEX': 'CREATE INDEX',
        'AUTO_INCREMENT': 'SERIAL / BIGSERIAL', # Use SERIAL/BIGSERIAL type instead
        'COMMENT': 'COMMENT ON COLUMN ... IS ...', # PostgreSQL uses COMMENT statements
        'CHARACTER_SET': 'NOT SUPPORTED',  # Character sets are defined at database level
        'COLLATE': 'COLLATE',

        # Operations
        'ADD': 'ADD',
        'ADD_COLUMN': 'ADD COLUMN',
        'MODIFY_COLUMN': 'ALTER COLUMN',  # Use ALTER TABLE ... ALTER COLUMN
        'CHANGE': 'ALTER COLUMN',         # Similar to MODIFY
        'DROP_COLUMN': 'DROP COLUMN',
        'RENAME_COLUMN': 'RENAME COLUMN',
        'ADD_INDEX': 'CREATE INDEX',
        'DROP_INDEX': 'DROP INDEX',
        'ALTER_TABLE': 'ALTER TABLE',
        'RENAME_TABLE': 'RENAME TO',
        'DROP_TABLE': 'DROP TABLE',
        'CREATE_TABLE': 'CREATE TABLE',

        # Functions
        'VERSION': 'SELECT version()'
    }

    
    def __init__(self, config): 
        try:
            self.connection = psycopg2.connect(
                host=config['host'],
                user=config['username'],
                password=config['password'],
                dbname=config['database'],
                port=config['port']
            )
            self.cursor = self.connection.cursor(cursor_factory=RealDictCursor)
            self.master = 'information_schema.tables' 

        except psycopg2.Error as e:
            raise Exception(f"PostgreSQL connection error: {e}")

    def execute(self, query, params=None, autocommit=True):
        try:
            if params:
                self.cursor.execute(query, params)
            else:
                self.cursor.execute(query)
            if autocommit:
                self.commit()
        except psycopg2.Error as e:
            self.rollback()
            raise Exception(f"PostgreSQL execution error: {e}") 
        
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
