from src.core import Collection
from src.databases.query import Query

class Model:
    table = None 
    primary_key = "id"  
    attributes: dict | list
    casts: dict = {}  
    use_uuid = False
    provider = Query()
    protected = ['table', 'primary_key', 'attributes', 'casts', 'provider', 'use_uuid']

    def __init__(self, attributes):
        self.attributes = attributes
 
    @classmethod
    def query(cls): 
        if not cls.provider.script:
           return cls.provider.select(cls.table)
        return cls.provider

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
        if column:
            self.attributes:dict = column
        self.provider.update(self.table, **self.attributes).where(**{self.primary_key : self.attributes[self.primary_key]}).execute()
        return self

    def delete(self): 
        self.provider.delete(self.table).where(**{self.primary_key : self.attributes[self.primary_key]}).execute()

    @classmethod
    def all(cls):
        cls.attributes = cls.provider.select(cls.table).fetchall()
        return cls(cls.attributes)

    @classmethod
    def find(cls, id): 
        cls.attributes = cls.query().where(id=id).fetchone()
        return cls(cls.attributes)     

    @classmethod
    def where(cls, **kwargs): 
        cls.attributes = cls.query().where(**kwargs).fetchall()
        return cls(cls.attributes) 

    @classmethod
    def where_not(cls, **kwargs):
        cls.attributes = cls.query().where_not(**kwargs).fetchall()
        return cls(cls.attributes)

    @classmethod
    def or_where(cls, **kwargs):
        cls.attributes = cls.query().or_where(**kwargs).fetchall()
        return cls(cls.attributes)

    @classmethod
    def like(cls, **kwargs):
        cls.attributes = cls.query().like(**kwargs).fetchall()
        return cls(cls.attributes)

    @classmethod
    def take(cls, value:int):
        cls.attributes = cls.query().limit(value).fetchall()
        return cls(cls.attributes)
    
    @classmethod
    def first(cls):  
        cls.attributes = cls.query().first().fetchone()   
        return cls(cls.attributes)
    
    @classmethod 
    def last(cls):  
        cls.attributes = cls.query().last().fetchone() 
        return cls(cls.attributes)
 
    def order_by(self, column='id'):
        self.attributes = self.query().order_by(column).fetchall()
        return self
 
    def order_by_desc(self, column='id'):
        self.attributes = self.query().order_by(column, "DESC").fetchall()
        return self
 
    def count(self, column='id'): 
        result = self.query().count(column).fetchone()
        return next(iter(result.values())) if isinstance(result, dict) else result[0] if isinstance(result, tuple) else result
    
    def pluck(cls, column):
        return [row[column] for row in cls.get()]
    
    @classmethod
    def paginate(cls, per_page:int, page:int=1):
        cls.attributes = cls.query().paginate(page, per_page).fetchall()
        return cls(cls.attributes)

    def fill(self, **kwargs):
        for key, value in kwargs.items():
            if key not in self.protected:
                self.attributes[key] = value
        return self 

    def get(self): 
        if isinstance(self.attributes, list):
            return [self.__class__(row) for row in self.attributes]
        elif isinstance(self.attributes, dict):
            return [self.__class__(self.attributes)]
        return []
    
    def collect(self):
        return Collection(self.attributes)

    @classmethod
    def exists(cls, **kwargs):
        return cls.where(**kwargs).count() > 0
    
    def belongs_to(self, related:'Model', foreign_key, primary_key=primary_key): 
        value = self.attributes.get(foreign_key)
        if not value:
            return None
        return related.where(**{primary_key: value}).first()

    def has_many(self, related:'Model', foreign_key, primary_key=primary_key): 
        value = self.attributes.get(primary_key)
        if not value:
            return []
        return related.where(**{foreign_key: value})
    
    def has_one(self, related:'Model', foreign_key, primary_key=primary_key):
        value = self.attributes.get(primary_key)
        if not value:
            return None
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


    def __str__(self):
        return str(self.attributes) 
    
    def __getattr__(self, key):
        if isinstance(self.attributes, dict):
            if key in self.attributes:
                value = self.attributes[key] 
                if key in self.casts:
                    caster = self.casts[key]
                    return caster(value) if callable(caster) else caster(value)
                return value
        raise AttributeError(f"{key} not found")


    def __getitem__(self, index): 
        try:
            return self.attributes[index]
        except (IndexError, KeyError, TypeError):
            raise AttributeError
    def __setattr__(self, key, value):
        if key in self.protected:
            super().__setattr__(key, value)
        else: 
            self.attributes[key] = value
            
    def __iter__(self): 
        return iter(self)
 
    def __len__(self):
        if self.attributes is None:
            return 0
        return len(self.attributes)

    
    def __repr__(self):
        return str(self.attributes)