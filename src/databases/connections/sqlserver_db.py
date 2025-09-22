try:
    import pyodbc
except:
    raise ImportError("pyodbc is not installed. Please install it using 'py creator install pyodbc'")

from .rdbms import RDBMS

class SQLServer(RDBMS):
    """SQL Server-specific implementation of the database connector."""
    placeholder = '?'  # SQL Server uses ? as placeholder in pyodbc

    syntax = {
        # Customs
        'ID': 'BIGINT',
        'UUID': 'UNIQUEIDENTIFIER',

        # Types
        'BIGINT': 'BIGINT',
        'INT': 'INT',
        'SMALLINT': 'SMALLINT',
        'TINYINT': 'TINYINT',
        'FLOAT': 'FLOAT',
        'REAL': 'REAL',
        'DECIMAL': 'DECIMAL',
        'NUMERIC': 'NUMERIC',
        'BIT': 'BIT',
        'CHAR': 'CHAR',
        'NCHAR': 'NCHAR',
        'VARCHAR': 'VARCHAR',
        'NVARCHAR': 'NVARCHAR',
        'TEXT': 'TEXT',
        'NTEXT': 'NTEXT',
        'BINARY': 'BINARY',
        'VARBINARY': 'VARBINARY',
        'IMAGE': 'IMAGE',
        'XML': 'XML',
        'JSON': 'NVARCHAR(MAX)',  # SQL Server n'a pas de JSON natif avant 2016 (mais fonctions JSON existent)
        'DATE': 'DATE',
        'DATETIME': 'DATETIME',
        'DATETIME2': 'DATETIME2',
        'SMALLDATETIME': 'SMALLDATETIME',
        'TIME': 'TIME',
        'TIMESTAMP': 'ROWVERSION',  # différent de MySQL
        'UNIQUEIDENTIFIER': 'UNIQUEIDENTIFIER',

        # Constraints / Keys
        'PRIMARY_KEY': 'PRIMARY KEY',
        'FOREIGN_KEY': 'FOREIGN KEY',
        'REFERENCES': 'REFERENCES',
        'NOT_NULL': 'NOT NULL',
        'NULL': 'NULL',
        'UNIQUE': 'UNIQUE',
        'CHECK': 'CHECK',
        'DEFAULT': 'DEFAULT',
        'ON_UPDATE': 'ON UPDATE',  # SQL Server utilise triggers pour certains cas
        'ON_DELETE': 'ON DELETE',
        'INDEX': 'INDEX',
        'IDENTITY': 'IDENTITY(1,1)',  # Auto-incrément
        'COLLATE': 'COLLATE',

        # Operations
        'ADD': 'ADD',
        'ADD_COLUMN': 'ADD COLUMN',
        'ALTER_COLUMN': 'ALTER COLUMN',
        'DROP_COLUMN': 'DROP COLUMN',
        'RENAME_COLUMN': 'sp_rename',  # via procédure système
        'ADD_INDEX': 'CREATE INDEX',
        'DROP_INDEX': 'DROP INDEX',
        'ALTER_TABLE': 'ALTER TABLE',
        'RENAME_TABLE': 'sp_rename',
        'DROP_TABLE': 'DROP TABLE',
        'CREATE_TABLE': 'CREATE TABLE',

        # Functions
        'VERSION': 'SELECT @@VERSION'
    }

    def __init__(self, config):
        try:
            self.connection = pyodbc.connect(
                f"DRIVER={{ODBC Driver 17 for SQL Server}};"
                f"SERVER={config['host']};"
                f"DATABASE={config['database']};"
                f"UID={config['username']};"
                f"PWD={config['password']}"
            )
            self.cursor = self.connection.cursor()
            self.master = 'INFORMATION_SCHEMA.TABLES'
        except pyodbc.Error as e:
            raise Exception(e)

    def execute(self, query, params=None, autocommit=True):
        try:
            if params:
                self.cursor.execute(query, params)
            else:
                self.cursor.execute(query)
            if autocommit:
                self.commit()
        except pyodbc.Error as e:
            self.rollback()
            raise Exception(e)

    def fetchall(self):
        columns = [column[0] for column in self.cursor.description]
        return [dict(zip(columns, row)) for row in self.cursor.fetchall()]

    def fetchone(self):
        row = self.cursor.fetchone()
        if row:
            columns = [column[0] for column in self.cursor.description]
            return dict(zip(columns, row))
        return None

    def commit(self):
        return self.connection.commit()

    def rollback(self):
        self.connection.rollback()

    def close(self):
        if self.cursor:
            self.cursor.close()
        if self.connection:
            self.connection.close()
