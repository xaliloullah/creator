from src.databases.connections import Connector
from src.core import String
syntax = Connector.database().syntax

class Column:
    def __init__(self, use_foreign_keys = False):
        self.use_foreign_keys = use_foreign_keys
        self.definition = []  
        self.foreign_keys = []
        self._name_ = None

    def __str__(self):
        return self.get_syntax()
    
    def get(self):
        return ", ".join(self.definition + (self.foreign_keys if self.use_foreign_keys else []))

    # --- Column Types ---
    def id(self, name:str="id", size:int=20):
        self.definition.append(f"{name} {syntax['ID']} {syntax['UNSIGNED']} {syntax['PRIMARY_KEY']} {syntax['AUTO_INCREMENT']}")
        return self

    def uuid(self, name: str = "uuid", default=True): 
        self.definition.append(f"{name} {syntax['UUID']}") 
        return self

    def string(self, name:str, size:int=255):
        self.definition.append(f"{name} {syntax['VARCHAR']}({size})")
        return self

    def text(self, name:str):
        self.definition.append(f"{name} {syntax['TEXT']}")
        return self

    def integer(self, name:str, size:int=None):
        size = f"({size})" if size else ""
        self.definition.append(f"{name} {syntax['INT']}{size}")
        return self
    
    def bigint(self, name,size=20):
        self.definition.append(f"{name} {syntax['BIGINT']}({size})" )
        return self

    def smallint(self, name,size=20):
        self.definition.append(f"{name} {syntax['SMALLINT']}({size})")
        return self

    def mediumint(self, name,size=20):
        self.definition.append(f"{name} {syntax['MEDIUMINT']}({size})")
        return self

    def char(self, name, size=255):
        self.definition.append(f"{name} {syntax['CHAR']}({size})")
        return self

    def float(self, name,size=10):
        self.definition.append(f"{name} {syntax['FLOAT']}({size})")
        return self

    def double(self, name):
        self.definition.append(f"{name} {syntax['DOUBLE']}")
        return self

    def tinytext(self, name):
        self.definition.append(f"{name} {syntax['TINYTEXT']}")
        return self

    def varbinary(self, name, size=255):
        self.definition.append(f"{name} {syntax['VARBINARY']}({size})")
        return self

    def binary(self, name):
        self.definition.append(f"{name} {syntax['BINARY']}")
        return self

    def bit(self, name):
        self.definition.append(f"{name} {syntax['BIT']}")
        return self

    def numeric(self, name, precision=10, scale=2):
        self.definition.append(f"{name} {syntax['NUMERIC']}({precision}, {scale})")
        return self

    def date(self, name):
        self.definition.append(f"{name} {syntax['DATE']}")
        return self

    def comment(self, text):
        self.definition[-1] += f" {syntax['COMMENT']} '{text}'"
        return self

    def real(self, name:str, size:int=10):
        self.definition.append(f"{name} {syntax['REAL']}({size})")
        return self

    def tinyint(self, name:str, size:int=4):
        self.definition.append(f"{name} {syntax['TINYINT']}({size})")
        return self

    def decimal(self, name:str, precision:int=10, scale:int=2):
        if syntax['DECIMAL'] == 'DECIMAL':
            size = f"({precision}, {scale})"
        else:
            size=''
        
        self.definition.append(f"{name} {syntax['DECIMAL']}{size}")
        return self

    def datetime(self, name:str):
        self.definition.append(f"{name} {syntax['DATETIME']}")
        return self

    def time(self, name:str):
        self.definition.append(f"{name} {syntax['TIME']}")
        return self

    def json(self, name:str):
        self.definition.append(f"{name} {syntax['JSON']}")
        return self

    def enum(self, name:str, values):
        values_str = ", ".join([f"'{v}'" for v in values])
        self.definition.append(f"{name} {syntax['ENUM']}({values_str})")
        return self

    def boolean(self, name):
        self.definition.append(f"{name} {syntax['BOOLEAN']}")
        return self

    def blob(self, name, size=None):
        if size:
            self.definition.append(f"{name} {syntax['BLOB']}({size})")
        else:
            self.definition.append(f"{name} {syntax['BLOB']}")
        return self
    
    def timestamp(self, name:str):
        self.definition.append(f"{name} {syntax['TIMESTAMP']}")
        return self

    def timestamps(self):
        self.definition.append(f"created_at {syntax['TIMESTAMP']}")
        self.definition.append(f"updated_at {syntax['TIMESTAMP']}")
        return self
    
    # --- Constraints & Foreign Keys ---
    def primary(self):
        self.definition.append(f"{syntax['PRIMARY_KEY']}")
        return self

    def auto_increment(self):
        self.definition.append(f"{syntax['AUTO_INCREMENT']}")
        return self
    
    def foreign_id(self, name:str):
        self._name_ = name
        self.definition.append(f"{name} {syntax['ID']} {syntax['UNSIGNED']}") 
        return self
    
    def constrained(self, parent:str="", id='id'):
        if not parent:
            parent = self._name_.split('_')[0]
        parent = String(parent).pluralize()
        self.foreign_keys.append(f"CONSTRAINT fk_{parent} {syntax['FOREIGN_KEY']} ({self._name_}) {syntax['REFERENCES']} {parent}({id})") 
        return self

    def unique(self):
        self.definition[-1] += f" {syntax['UNIQUE']}"
        return self
    
    def on_update(self, arg="SET NULL"):
        self.foreign_keys[-1] += f" {syntax['ON_UPDATE']} {arg}"
        return self

    def on_delete(self, arg="SET NULL"):
        self.foreign_keys[-1] += f" {syntax['ON_DELETE']} {arg}"
        return self

    def check(self, name, condition):
        self.definition[-1] += f" {syntax['CHECK']} ({name} {condition})"
        return self

    def index(self, name):
        self.definition[-1] += f" {syntax['INDEX']} ({name})"
        return self

    def default(self, default):
        self.definition[-1] += f" {syntax['DEFAULT']} {default}"
        return self

    def nullable(self):
        self.definition[-1] += f" {syntax['NULL']}"
        return self

    def not_null(self):
        self.definition[-1] += f" {syntax['NOT_NULL']}"
        return self

    def unsigned(self): 
        if self.definition:
            self.definition[-1] += f" {syntax['UNSIGNED']}"
        return self
    
    def charset(self, name='utf8mb4', collation='utf8mb4_unicode_ci'):
        if self.definition:
            self.definition[-1] += f" CHARACTER SET {name} COLLATE {collation}"
        return self