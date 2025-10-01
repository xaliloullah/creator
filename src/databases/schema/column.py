from typing import Any, Optional
from src.databases.connections import Connector
from src.core import String 

class Column:
    def __init__(self, table=None):
        self.use_foreign_keys = False
        self.definitions = []  
        self.constraints = [] 
        self.indexes = []
        self.table = table
        self.name: str | Any = None

    # --- Column Types ---
    def id(self, name: str = "id"):
        self.add_definition(f"{name} {Connector.syntax('ID')}")
        self.unsigned()
        self.primary()
        self.auto_increment()
        return self

    def uuid(self, name: str = "uuid"):
        self.add_definition(f"{name} {Connector.syntax('UUID')}")
        return self

    def string(self, name: str, size: int = 255):
        self.add_definition(f"{name} {Connector.syntax('VARCHAR')}({size})")
        self.charset()
        self.not_null()
        return self

    def text(self, name: str):
        self.add_definition(f"{name} {Connector.syntax('TEXT')}")
        self.charset()
        return self

    def integer(self, name: str, size: Optional[int] = None):
        bits = f"({size})" if size else ""
        self.add_definition(f"{name} {Connector.syntax('INT')}{bits}")
        return self

    def bigint(self, name, size=20):
        self.add_definition(f"{name} {Connector.syntax('BIGINT')}({size})")
        return self

    def smallint(self, name, size=20):
        self.add_definition(f"{name} {Connector.syntax('SMALLINT')}({size})")
        return self

    def mediumint(self, name, size=20):
        self.add_definition(f"{name} {Connector.syntax('MEDIUMINT')}({size})")
        return self

    def char(self, name, size=255):
        self.add_definition(f"{name} {Connector.syntax('CHAR')}({size})")
        return self

    def float(self, name, size=10):
        self.add_definition(f"{name} {Connector.syntax('FLOAT')}({size})")
        return self

    def double(self, name):
        self.add_definition(f"{name} {Connector.syntax('DOUBLE')}")
        return self

    def tinytext(self, name):
        self.add_definition(f"{name} {Connector.syntax('TINYTEXT')}")
        return self

    def varbinary(self, name, size=255):
        self.add_definition(f"{name} {Connector.syntax('VARBINARY')}({size})")
        return self

    def binary(self, name):
        self.add_definition(f"{name} {Connector.syntax('BINARY')}")
        return self

    def bit(self, name):
        self.add_definition(f"{name} {Connector.syntax('BIT')}")
        return self

    def numeric(self, name, precision=10, scale=2):
        self.add_definition(f"{name} {Connector.syntax('NUMERIC')}({precision}, {scale})")
        return self

    def date(self, name):
        self.add_definition(f"{name} {Connector.syntax('DATE')}")
        return self

    def comment(self, text):
        self.add_definition(f"{Connector.syntax('COMMENT')} '{text}'", mode="insert")
        return self

    def real(self, name: str, size: int = 10):
        self.add_definition(f"{name} {Connector.syntax('REAL')}({size})")
        return self

    def tinyint(self, name: str, size: int = 4):
        self.add_definition(f"{name} {Connector.syntax('TINYINT')}({size})")
        return self

    def decimal(self, name: str, precision: int = 10, scale: int = 2):
        if Connector.syntax('DECIMAL') == 'DECIMAL':
            size = f"({precision}, {scale})"
        else:
            size = ''
        self.add_definition(f"{name} {Connector.syntax('DECIMAL')}{size}")
        return self

    def datetime(self, name: str):
        self.add_definition(f"{name} {Connector.syntax('DATETIME')}")
        return self

    def time(self, name: str):
        self.add_definition(f"{name} {Connector.syntax('TIME')}")
        return self

    def json(self, name: str):
        self.add_definition(f"{name} {Connector.syntax('JSON')}")
        self.charset(collation="utf8mb4_bin")
        return self

    def enum(self, name: str, values):
        values_str = ", ".join([f"'{v}'" for v in values])
        self.add_definition(f"{name} {Connector.syntax('ENUM')}({values_str})")
        return self

    def boolean(self, name):
        self.add_definition(f"{name} {Connector.syntax('BOOLEAN')}")
        return self

    def blob(self, name, size=None):
        if size:
            self.add_definition(f"{name} {Connector.syntax('BLOB')}({size})")
        else:
            self.add_definition(f"{name} {Connector.syntax('BLOB')}")
        return self

    def timestamp(self, name: str):
        self.add_definition(f"{name} {Connector.syntax('TIMESTAMP')}")
        return self

    def timestamps(self):
        self.timestamp("created_at").default('CURRENT_TIMESTAMP')
        self.timestamp("updated_at").default('CURRENT_TIMESTAMP').on_update('CURRENT_TIMESTAMP')
        return self

    def soft_delete(self):
        self.timestamp("deleted_at").nullable()
        return self

    # --- Constraint & Foreign Keys ---
    def primary(self):
        self.add_definition(f"{Connector.syntax('PRIMARY_KEY')}", mode="insert")
        return self

    def auto_increment(self):
        self.add_definition(f"{Connector.syntax('AUTO_INCREMENT')}", mode="insert")
        return self

    def foreign_id(self, name: str):
        self.name = name
        self.add_definition(f"{name} {Connector.syntax('ID')}")
        self.unsigned()
        return self

    def foreign_key(self, name: str):
        self.add_constraint(f"{Connector.syntax('FOREIGN_KEY')} ({name})", mode="insert")
        return self

    def references(self, table, primary_key):
        self.add_constraint(f"{Connector.syntax('REFERENCES')} {table}({primary_key})", mode="insert")
        return self

    def constrained(self, table: str = "", primary_key='id'):
        table = table or String(self.name.split('_')[0]).pluralize()
        self.add_constraint(f"CONSTRAINT fk_{table}")
        self.foreign_key(self.name)
        self.references(table, primary_key)
        self.index(self.name, f"{self.table}_{self.name}_foreign")
        return self

    def unique(self):
        self.add_definition(f"{Connector.syntax('UNIQUE')}", mode="insert")
        return self

    def on_update(self, value="SET NULL"):
        if Connector.syntax("ON_UPDATE"):
            self.add_constraint(f"{Connector.syntax('ON_UPDATE')} {value.upper()}", mode="insert")
        return self

    def on_delete(self, value="SET NULL"):
        if Connector.syntax("ON_DELETE"):
            self.add_constraint(f"{Connector.syntax('ON_DELETE')} {value.upper()}", mode="insert")
        return self

    def check(self, name, condition):
        self.add_definition(f"{Connector.syntax('CHECK')} ({name} {condition})", mode="insert")
        return self

    def index(self, column, name=None):
        self.add_index(f"{Connector.syntax('INDEX')} {name if name else column} ({column})")
        return self

    def default(self, value):
        if isinstance(value, str) and not value.upper().startswith('CURRENT_'):
            value = f"'{value}'"
        self.add_definition(f"{Connector.syntax('DEFAULT')} {value}", mode="insert")
        return self

    def nullable(self):
        self.add_definition(f"{Connector.syntax('NULL')}", mode="insert")
        return self

    def not_null(self):
        self.add_definition(f"{Connector.syntax('NOT_NULL')}", mode="insert")
        return self

    def unsigned(self):
        self.add_definition(f"{Connector.syntax('UNSIGNED')}", mode="insert")
        return self

    def charset(self, **kwargs):
        if Connector.syntax("CHARACTER_SET"):
            name = kwargs.get("name", "utf8mb4")
            collation = kwargs.get("collation", "utf8mb4_unicode_ci")
            self.add_definition(f"{Connector.syntax('CHARACTER_SET')} {name} COLLATE {collation}", mode="insert")
        return self

    # alters
    def add(self):
        self.add_definition(Connector.syntax("ADD_COLUMN"), mode="prepend")
        self.add_constraint(Connector.syntax("ADD"), mode="prepend")
        self.add_index(Connector.syntax("ADD"), mode="prepend")
        return self

    def modify(self):
        if Connector.syntax("MODIFY_COLUMN"):
            self.add_definition(Connector.syntax("MODIFY_COLUMN"), mode="prepend")
            self.add_constraint("MODIFY", mode="prepend")
            self.add_index("MODIFY", mode="prepend")
        return self

    def change(self, old):
        if Connector.syntax("CHANGE"):
            self.add_definition(f"{Connector.syntax('CHANGE')} {old}", mode="prepend")
            self.add_constraint("CHANGE", mode="prepend")
            self.add_index("CHANGE", mode="prepend")
        return self

    def drop(self, name):
        self.add_constraint("DROP", mode="prepend")
        self.add_definition(f"{Connector.syntax('DROP_COLUMN')} {name}")
        self.add_index("DROP", mode="prepend")

    def rename(self, old, new):
        self.add_definition(f"{Connector.syntax('RENAME_COLUMN')} {old} TO {new}")
        self.add_constraint("RENAME", mode="prepend")
        self.add_index("RENAME", mode="prepend")
        return self

    # generate
    def __str__(self):
        return self.generate()

    def _add(self, collection: list, sql, mode="append"):
        if mode == "append":
            collection.append(sql)
        elif mode == "prepend":
            if collection:
                collection[-1] = f"{sql} {collection[-1]}"
        elif mode == "insert":
            if collection:
                collection[-1] += f" {sql}"
        else:
            raise ValueError()
        return self

    def add_definition(self, sql, mode="append"):
        return self._add(self.definitions, sql, mode)

    def add_constraint(self, sql, mode="append"):
        return self._add(self.constraints, sql, mode)

    def add_index(self, sql, mode="append"):
        return self._add(self.indexes, sql, mode)

    def generate(self, **kwargs):
        separator: str = kwargs.get('separator', ",")
        multiline: bool = kwargs.get('multiline', False)
        command: bool = kwargs.get('command', False)
        reverse: bool = kwargs.get('reverse', False)

        separator += ("\n" if multiline else " ")

        sql = self.definitions + self.constraints
        if reverse:
            sql = self.constraints + self.definitions

        sql.extend(self.indexes)

        if command:
            sql = [script if str(script).endswith(";") else script + ";" for script in sql]
            return sql
        return separator.join(sql)
