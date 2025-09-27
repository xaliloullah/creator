from typing import Any
from src.core import Storage, Collection, Crypt, Path


class Structure: 
    def __init__(self, path:str|Path, **kwargs):   
        self.path = path 
        self.format = kwargs.get("format", 'json')
        self.default = kwargs.get("default", {})
        self.absolute = kwargs.get("absolute", False)  
        # self.crypt = kwargs.get("crypt", False)
        self.provider = Storage(self.path, format=self.format, absolute=self.absolute, default=self.default)
        self.data:Any = self.provider.load()

    def all(self):
        self.data = self.provider.load() 
        return self    
    
    def create(self, **kwargs):
        for key, value in kwargs.items():
            self.set(key, value, autosave=False)
        self.provider.create(self.data)
        return self 

    def update(self, **kwargs):
        for key, value in kwargs.items():
            self.set(key, value, autosave=False)
        self.provider.update(self.data)
        return self  

    def destroy(self):
        self.provider.delete()

    def get(self, key: str, default=None) -> Any: 
        keys = key.split(".")
        items = self.data
        for key in keys:
            if isinstance(items, dict) and key in items:
                items = items[key]
            else:
                return default
            
        # if self.crypt and Crypt.is_encrypted(items):
        #     return Crypt.decrypt(items)
        return items  

    def set(self, key: str, value, autosave=True):
        keys = key.split(".")
        items = self.data
        for k in keys[:-1]:
            if k not in items or not isinstance(items[k], dict):
                items[k] = {}
            items = items[k]
        # if self.crypt:
        #     value = Crypt.encrypt(value)
        items[keys[-1]] = value
        if autosave:
            self.update(**self.data)
        return self
    
    def collect(self):
        return Collection(self.data) 
    
    def __str__(self):
        return str(self.data)