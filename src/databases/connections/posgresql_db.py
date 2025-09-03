import psycopg2
from psycopg2.extras import RealDictCursor
from .builder import DatabaseBuilder

class PostgreSQL(DatabaseBuilder):
    """PostgreSQL-specific implementation of the database connector."""
    syntax = {
        'ID': 'SERIAL',
        'UUID': 'UUID',
        'VARCHAR': 'VARCHAR',
        'BIGINT': 'BIGINT',
        'INT': 'INTEGER',
        'SMALLINT': 'SMALLINT',
        'MEDIUMINT': 'INTEGER',
        'CHAR': 'CHAR',
        'FLOAT': 'REAL',
        'DATE': 'DATE',
        'DECIMAL': 'DECIMAL',
        'DOUBLE': 'DOUBLE PRECISION',
        'TINYTEXT': 'TEXT',
        'TINYINT': 'SMALLINT',
        'VARBINARY': 'BYTEA',
        'BINARY': 'BYTEA',
        'BLOB': 'BYTEA',
        'ENUM': 'TEXT',  # PostgreSQL uses CHECK or ENUM types separately
        'TEXT': 'TEXT',
        'JSON': 'JSONB',
        'BIT': 'BIT',
        'BOOLEAN': 'BOOLEAN',
        'DATETIME': 'TIMESTAMP',
        'NUMERIC': 'NUMERIC',
        'STRING': 'TEXT',
        'TIME': 'TIME',
        'AUTO_INCREMENT': '',  # handled via SERIAL
        'PRIMARY_KEY': 'PRIMARY KEY',
        'FOREIGN_KEY': 'FOREIGN KEY',
        'REFERENCES': 'REFERENCES',
        'DEFAULT': 'DEFAULT',
        'NOT_NULL': 'NOT NULL',
        'NULL': 'NULL',
        'UNIQUE': 'UNIQUE',
        'SET_NULL': 'SET NULL',
        'CHECK': 'CHECK',
        'COMMENT': '--',  # PostgreSQL COMMENT handled differently
        'TIMESTAMP': 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
        'UNSIGNED': '',  # PostgreSQL does not support UNSIGNED natively
        'ON_UPDATE': 'ON UPDATE',
        'ON_DELETE': 'ON DELETE',
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
            self.placeholder = '%s'

        except psycopg2.Error as e:
            raise Exception(f"PostgreSQL connection error: {e}")

    def execute(self, query, params=None):
        try:
            if params:
                self.cursor.execute(query, params)
            else:
                self.cursor.execute(query)
            self.connection.commit()
        except psycopg2.Error as e:
            self.connection.rollback()
            raise Exception(f"PostgreSQL execution error: {e}") 