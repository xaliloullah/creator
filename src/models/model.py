from src.databases import Query

class Model:
    table = None 
    attributes: dict | list = None
    casts: dict = {}
    provider = Query()
    primary_key = "id"  
    protected = ['attributes', 'casts', 'provider', 'table', 'primary_key']

    def __init__(self, attributes):
        self.attributes = attributes 

    @classmethod
    def create(cls, **column):
        cls.provider.insert(cls.table, **column).execute()
        return cls.where(**column).first()

    def update(self, **kwargs):
        if self.primary_key not in self.attributes:
            raise ValueError(f"Cannot update model without {self.primary_key}") 
        self.provider.update(self.table, **kwargs).where(id=self.attributes[self.primary_key]).execute()

    def delete(self): 
        self.provider.delete(self.table).where(id=self.attributes[self.primary_key]).execute()

    @classmethod
    def drop(cls):
        cls.provider.drop(cls.table).execute()
        
    @classmethod
    def all(cls):
        cls.attributes = cls.provider.select(cls.table).fetchall()
        return cls(cls.attributes)

    @classmethod
    def find(cls, id): 
        cls.attributes = cls.provider.select(cls.table).where(id=id).fetchone()
        return cls(cls.attributes)     

    @classmethod
    def where(cls, **kwargs): 
        cls.attributes = cls.provider.select(cls.table).where(**kwargs).fetchall()
        return cls(cls.attributes) 

    @classmethod
    def where_not(cls, **kwargs):
        cls.attributes = cls.provider.select(cls.table).where_not(**kwargs).fetchall()
        return cls(cls.attributes)

    @classmethod
    def or_where(cls, **kwargs):
        cls.attributes = cls.provider.select(cls.table).or_where(**kwargs).fetchall()
        return cls(cls.attributes)

    @classmethod
    def like(cls, **kwargs):
        cls.attributes = cls.provider.select(cls.table).like(**kwargs).fetchall()
        return cls(cls.attributes)

    @classmethod
    def take(cls, value:int):
        cls.attributes = cls.provider.select(cls.table).limit(value).fetchall()
        return cls(cls.attributes)
 
    def order_by(self, column='id'):
        self.attributes = self.provider.order_by(column).fetchall()
        return self
 
    def order_by_desc(self, column='id'):
        self.attributes = self.provider.order_by(column, "DESC").fetchall()
        return self
 
    def count(self, column='id'): 
        result = self.provider.count(column).fetchone()
        return next(iter(result.values())) if isinstance(result, dict) else result[0] if isinstance(result, tuple) else result
     
    def first(self):  
        self.attributes = self.provider.first().fetchone()   
        return self
     
    def last(self):  
        self.attributes = self.provider.last().fetchone() 
        return self
    
    def pluck(cls, column):
        return [row[column] for row in cls.all().get()]
    
    @classmethod
    def paginate(cls, per_page:int, page:int=1):
        cls.attributes = cls.provider.select(cls.table).paginate(page, per_page).fetchall()
        return cls(cls.attributes)

    def fill(self, **kwargs):
        for key, value in kwargs.items():
            if key not in self.protected:
                self.attributes[key] = value
        return self
    
    def soft_delete(self):
        self.update(deleted_at="CURRENT_TIMESTAMP")

    def clone(self):
        return self.__class__(self.attributes.copy())



    def get(self): 
        if isinstance(self.attributes, list):
            return [self.__class__(row) for row in self.attributes]
        elif isinstance(self.attributes, dict):
            return [self.__class__(self.attributes)]
        return []
    
    @classmethod
    def exists(cls, **kwargs):
        return cls.where(**kwargs).count() > 0

    def to_dict(self):
        return self.attributes

    def to_json(self):
        import json
        return json.dumps(self.attributes)

    @classmethod
    def first_or_create(cls, **kwargs):
        obj = cls.where(**kwargs).first().get()
        if obj:
            return obj[0]
        return cls.create(**kwargs)
    @classmethod
    def update_or_create(cls, search:dict, update:dict):
        obj = cls.where(**search).first().get()
        if obj:
            obj[0].update(**update)
            return obj[0]
        return cls.create(**{**search, **update})



    
    
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
    
    # def __getattr__(self, key):
    #     if isinstance(self.attributes, dict):
    #         if key in self.attributes:
    #             return self.attributes[key]
    #     raise AttributeError(f"{key} not found")
    
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
        return iter(self.attributes)

    def __len__(self):
        return len(self.attributes)
    
    def __repr__(self):
        return str(self.attributes)