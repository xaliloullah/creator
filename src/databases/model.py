from src.core import Collection, Date
from src.databases.query import Query

class Model:
    table: str= None 
    primary_key: str= "id"
    attributes: dict | list = []
    casts: dict = {}  
    use_uuid: bool= False 
    # connection: str= None
    provider = Query() 
    protected: list = ['table', 'primary_key', 'attributes', '_items_', 'casts', 'use_uuid', 'connection', 'provider', 'protected']

    def __init__(self, attributes: dict | list):
        self.attributes = attributes 
        if isinstance(attributes, list):
            self._items_ = [self.__class__(attribute) for attribute in attributes]
        elif isinstance(attributes, dict):
            self._items_ = [self]
        else:
            self._items_ = []
        
    @classmethod
    def query(cls): 
        if cls.provider.script: 
            return cls.provider
        return cls.provider.select(cls.table)
    
    @classmethod
    def create(cls, **column):
        if cls.use_uuid and cls.primary_key not in column:
            import uuid
            column[cls.primary_key] = str(uuid.uuid4())
        cls.provider.insert(cls.table, **column).execute()
        return cls.where(**column).first()
    
    @classmethod
    def drop(cls):
        cls.provider.drop(cls.table).execute()
    
    def save(self):
        if self.primary_key in self.attributes:
            return self.update(**self.attributes)
        else:
            new = self.create(**self.attributes)
            self.attributes = new.attributes
            return self

    def update(self, **column):
        if self.primary_key not in self.attributes:
            raise ValueError(f"Cannot update model without {self.primary_key}") 
        if not column:
            column:dict = self.attributes
        self.provider.update(self.table, **column).where(**{self.primary_key : self.attributes[self.primary_key]}).execute()
        return self

    def delete(self): 
        self.provider.delete(self.table).where(**{self.primary_key : self.attributes[self.primary_key]}).execute()
    
    @classmethod
    def all(cls): 
        return cls(cls.query().fetchall())
    
    @classmethod
    def where(cls, **kwargs): 
        cls.query().where(**kwargs) 
        return cls

    @classmethod
    def where_not(cls, **kwargs):  
        cls.query().where_not(**kwargs)
        return cls
    
    @classmethod
    def or_where(cls, **kwargs):
        cls.query().or_where(**kwargs)
        return cls
    
    @classmethod
    def where_null(cls, column): 
        cls.query().where_null(column)
        return cls
    
    @classmethod
    def where_not_null(cls, column): 
        cls.query().where_not_null(column)
        return cls
    
    @classmethod
    def where_in(cls, **kwargs): 
        cls.query().clause('IN', **kwargs)
        return cls
    
    @classmethod
    def where_not_in(cls, **kwargs): 
        cls.query().clause('NOT IN', **kwargs)
        return cls
    
    @classmethod
    def or_where_in(cls, **kwargs): 
        cls.query().or_clause('IN', **kwargs)
        return cls
    
    @classmethod
    def or_where_not_in(cls, **kwargs): 
        cls.query().or_clause('NOT IN', **kwargs)
        return cls
     
    @classmethod
    def find(cls, id):  
        return cls(cls.query().where(id=id).fetchone())  

    @classmethod
    def like(cls, **kwargs):
        cls.query().like(**kwargs)
        return cls

    @classmethod
    def take(cls, value:int):
        cls.query().limit(value)
        return cls.get()
    
    @classmethod
    def first(cls):
        return cls(cls.query().first().fetchone())
    
    @classmethod
    def last(cls):
        return cls(cls.query().last().fetchone())
 
    @classmethod
    def order_by(cls, column='id'):
        cls.query().order_by(column)
        return cls
    
    @classmethod
    def order_by_desc(cls, column='id'):
        cls.query().order_by(column, "DESC")
        return cls.get()
    
    @classmethod
    def count(cls, column='id'): 
        result = cls.query().count(column).fetchone()
        if isinstance(result, dict):
            return next(iter(result.values()))
        elif isinstance(result, tuple):
            return result[0]
        return result

    @classmethod
    def raw(cls, sql, values=()):
        cls.query().raw(sql, values)
        return cls

    @classmethod
    def union(cls, subquery):
        cls.query().union(subquery.query())
        return cls

    @classmethod
    def union_all(cls, subquery):
        cls.query().union_all(subquery.query())
        return cls

    @classmethod
    def between(cls, column, start, end):
        cls.query().between(column, start, end)
        return cls

    @classmethod
    def not_between(cls, column, start, end):
        cls.query().not_between(column, start, end)
        return cls

    @classmethod
    def having(cls, **kwargs):
        cls.query().having(**kwargs)
        return cls

    @classmethod
    def group_by(cls, *columns):
        cls.query().group_by(*columns)
        return cls.get()

    @classmethod
    def alias(cls, name):
        cls.query().alias(name)
        return cls

    @classmethod
    def join(cls, table, type="INNER"):
        cls.query().join(table, type)
        return cls

    @classmethod
    def left_join(cls, table):
        cls.query().left_join(table)
        return cls

    @classmethod
    def right_join(cls, table):
        cls.query().right_join(table)
        return cls

    @classmethod
    def full_join(cls, table):
        cls.query().full_join(table)
        return cls

    @classmethod
    def on(cls, **kwargs):
        cls.query().on(**kwargs)
        return cls

    @classmethod
    def subquery(cls, query, alias="subquery"):
        cls.query().subquery(query, alias)
        return cls

    @classmethod
    def paginate(cls, per_page:int, page:int=1):
        cls.query().paginate(page, per_page)
        return cls.get()
    
    def collect(self):
        return Collection(self.attributes)

    @classmethod
    def exists(cls, **kwargs):
        return cls.where(**kwargs).count() > 0
    
    def to_dict(self):
        from datetime import datetime
        return {
            k: (v.isoformat() if isinstance(v, datetime) else v)
            for k, v in self.attributes.items()
        }

    def to_json(self):
        import json
        return json.dumps(self.to_dict())

    @classmethod
    def pluck(cls, column): 
        rows = cls.query().subquery(f"SELECT {column}").fetchall()
        return [row[column] for row in rows]

    @classmethod
    def value(cls, column):
        row = cls.query().subquery(f"SELECT {column}").fetchone()
        return row[column] if row else None

    @classmethod
    def first_or_create(cls, **kwargs):
        instance = cls.where(**kwargs).first()
        return instance if instance else cls.create(**kwargs)

    @classmethod
    def update_or_create(cls, lookup: dict, defaults: dict = {}):
        instance = cls.where(**lookup).first()
        if instance:
            instance.update(**defaults)
            return instance
        else:
            return cls.create(**{**lookup, **defaults})

    @classmethod
    def get(cls):
        return cls(cls.query().fetchall())
    
    def fill(self, **kwargs):
        for key, value in kwargs.items():
            if key not in self.protected:
                self.attributes[key] = value
        return self 
    
    def foreign_key(self):
        return self.__class__.__name__.lower() + f"_{self.primary_key}"

    def belongs_to(self, related:'Model', foreign_key, primary_key=primary_key): 
        value = self.attributes.get(foreign_key)
        if not value:
            return None
        return related.where(**{primary_key: value}).first()
    
    def has_many(self, related:'Model', foreign_key=None, primary_key=primary_key): 
        value = self.attributes.get(primary_key)
        if not value:
            return []
        if foreign_key is None:
            foreign_key = self.foreign_key()
        return related.where(**{foreign_key: value}).get()
    
    def has_one(self, related:'Model', foreign_key=None, primary_key=primary_key):
        value = self.attributes.get(primary_key)
        if not value:
            return None
        if foreign_key is None:
            foreign_key = self.foreign_key()
        return related.where(**{foreign_key: value}).first()
    
    def belongs_to_many(self, related:'Model', pivot_table, foreign_key, related_key, primary_key=primary_key, owner_key=primary_key):
        local_value = self.attributes.get(primary_key)
        if not local_value:
            return [] 
        rows = self.provider.select(pivot_table).where(**{foreign_key: local_value}).fetchall()
        related_ids = [row[related_key] for row in rows]

        if not related_ids:
            return []
        return related.where(**{owner_key: related_ids})
    
    def has_many_through(self, related:'Model', pivot_table, local_key, pivot_local, pivot_related, related_key):
        rows = self.provider.select(pivot_table).where(**{pivot_local: self.attributes[local_key]}).fetchall()
        ids = [row[pivot_related] for row in rows]
        return related.where(**{related_key: ids})
    
    # 
    def __str__(self):
        return str(self.attributes)

    def __repr__(self):
        return str(self.attributes) 
    
    def __iter__(self): 
        return iter(self._items_)
    
    def __getitem__(self, key): 
        try:
            return self.attributes[key]
        except (KeyError, IndexError, TypeError):
            raise KeyError
        
    def __setitem__(self, key, value): 
        try:
            return self.fill(**{key:value})
        except (ValueError, KeyError, TypeError):
            raise ValueError
        
    def __setattr__(self, key, value):
        if key in self.protected:
            super().__setattr__(key, value)
        else: 
            self.attributes[key] = value
    
    def __getattr__(self, key):
        if isinstance(self.attributes, dict):
            if key in self.attributes:
                value = self.attributes[key] 
                if key in self.casts:
                    caster = self.casts[key]
                    return caster(value) if callable(caster) else caster(value)
                return value
        raise AttributeError(f"{key} not found")