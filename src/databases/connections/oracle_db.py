try:
    import oracledb  # nouveau nom de cx_Oracle
except:
    raise ImportError("oracledb is not installed. Please install it using 'py creator install oracledb'")

from .rdbms import RDBMS

class Oracle(RDBMS):
    """Oracle-specific implementation of the database connector."""
    placeholder = ':'  # Oracle utilise :1, :2, etc. pour les paramètres

    syntax = {
        # Customs
        'ID': 'NUMBER(20)',
        'UUID': 'RAW(16)',  # Oracle n'a pas de UUID natif, mais on stocke en RAW

        # Types
        'BIGINT': 'NUMBER(19)',
        'INT': 'NUMBER(10)',
        'SMALLINT': 'NUMBER(5)',
        'TINYINT': 'NUMBER(3)',
        'FLOAT': 'BINARY_FLOAT',
        'DOUBLE': 'BINARY_DOUBLE',
        'DECIMAL': 'DECIMAL',
        'NUMERIC': 'NUMERIC',
        'CHAR': 'CHAR',
        'NCHAR': 'NCHAR',
        'VARCHAR': 'VARCHAR2',
        'NVARCHAR': 'NVARCHAR2',
        'CLOB': 'CLOB',
        'NCLOB': 'NCLOB',
        'BLOB': 'BLOB',
        'RAW': 'RAW',
        'LONG': 'LONG',
        'JSON': 'CLOB',  # Depuis Oracle 21c: JSON natif, sinon stocker en CLOB
        'DATE': 'DATE',
        'DATETIME': 'DATE',  # Oracle DATE inclut aussi l’heure
        'TIMESTAMP': 'TIMESTAMP',
        'TIMESTAMP_TZ': 'TIMESTAMP WITH TIME ZONE',
        'TIMESTAMP_LTZ': 'TIMESTAMP WITH LOCAL TIME ZONE',

        # Constraints / Keys
        'PRIMARY_KEY': 'PRIMARY KEY',
        'FOREIGN_KEY': 'FOREIGN KEY',
        'REFERENCES': 'REFERENCES',
        'NOT_NULL': 'NOT NULL',
        'NULL': 'NULL',
        'UNIQUE': 'UNIQUE',
        'CHECK': 'CHECK',
        'DEFAULT': 'DEFAULT',
        'ON_DELETE': 'ON DELETE',
        'INDEX': 'INDEX',

        # Operations
        'ADD': 'ADD',
        'ADD_COLUMN': 'ADD',
        'MODIFY_COLUMN': 'MODIFY',
        'DROP_COLUMN': 'DROP',
        'RENAME_COLUMN': 'RENAME COLUMN',
        'ADD_INDEX': 'CREATE INDEX',
        'DROP_INDEX': 'DROP INDEX',
        'ALTER_TABLE': 'ALTER TABLE',
        'RENAME_TABLE': 'RENAME',
        'DROP_TABLE': 'DROP TABLE',
        'CREATE_TABLE': 'CREATE TABLE',

        # Functions
        'VERSION': "SELECT * FROM v$version"
    }

    def __init__(self, config):
        try:
            self.connection = oracledb.connect(
                user=config['username'],
                password=config['password'],
                dsn=f"{config['host']}:{config.get('port', 1521)}/{config['service_name']}"
            )
            self.cursor = self.connection.cursor()
            self.master = 'ALL_TABLES'
        except oracledb.Error as e:
            raise Exception(e)

    def execute(self, query, params=None, autocommit=True):
        try:
            if params:
                self.cursor.execute(query, params)
            else:
                self.cursor.execute(query)
            if autocommit:
                self.commit()
        except oracledb.Error as e:
            self.rollback()
            raise Exception(e)

    def fetchall(self):
        columns = [d[0] for d in self.cursor.description]
        return [dict(zip(columns, row)) for row in self.cursor.fetchall()]

    def fetchone(self):
        row = self.cursor.fetchone()
        if row:
            columns = [d[0] for d in self.cursor.description]
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
