from src.core import Storage, Collection


class Structure: 
    def __init__(self, path, **kwargs):   
        self.path = path
        self.format = kwargs.get("format", 'json')
        self.default = kwargs.get("default", {})
        self.absolute = kwargs.get("absolute", False)  
        self.provider = Storage(self.path, format=self.format, absolute=self.absolute, default=self.default)
        self.data = self.provider.load()

    def all(self):
        self.data = self.provider.load() 
        return self    
    
    def create(self, **kwargs):
        self.provider.create(kwargs)

    def update(self, **kwargs):
        self.provider.update(kwargs)

    def destroy(self):
        self.provider.delete()

    def get(self, key: str, default=None): 
        keys = key.split(".")
        items = self.data
        for key in keys:
            if isinstance(items, dict) and key in items:
                items = items[key]
            else:
                return default
        return items  

    def set(self, key: str, value):
        keys = key.split(".")
        items = self.data
        for k in keys[:-1]:
            if k not in items or not isinstance(items[k], dict):
                items[k] = {}
            items = items[k]
        items[keys[-1]] = value
        self.update(**self.data)
        return self
    
    def collect(self):
        return Collection(self.data) 
    
    def __str__(self):
        return str(self.data)