from typing import Any
from src.core import File, Path, Collection, String

class Storage:

    def __init__(self, path: Path|str="", **kwargs):  
        self.path = path if isinstance(path, Path) else Path(path)
        self.format = kwargs.get("format", None)
        self.default = kwargs.get("default", None)
        self.absolute = kwargs.get("absolute", True)     
        
        if self.absolute:
            self.path = Path.storage(self.path)

        self.file = File(self.path) 

        if not self.format:
            self.format = self.file.get_extension(with_dot=False) 
        
        self.file.set_extension(self.format) 

        self.data:Any = self.load()  

    def load(self):
        try: 
            return self.file.load(format=self.format)
        except Exception:
            return self.default
    
    def save(self):
        try:
            data = self.data if self.data is not None else self.default
            self.file.save(data, format=self.format, default=self.default)
        except Exception as e:
            raise Exception(f"Failed to save storage: {e}")
    
    def create(self, data): 
        self.data = data
        self.save() 
        return self
    
    def update(self, data):
        try:
            if isinstance(self.data, dict):
                self.data.update(data)  
            elif isinstance(self.data, list):
                self.data.append(data)
            elif isinstance(self.data, set):
                self.data.add(data)
            elif isinstance(self.data, str):
                self.data += data
            else:
                self.data = data
            self.save()
            return self
        except Exception as e:
            raise Exception(e)
        
    def delete(self):
        return self.file.delete()
        
    def reset(self): 
        if isinstance(self.data, list):
            self.data = []
        elif isinstance(self.data, dict):
            self.data = {}
        elif isinstance(self.data, str):
            self.data = ""
        elif isinstance(self.data, set):
            self.data = set()
        else:
            raise TypeError("Invalid !")
        self.save()
        return self  
    
    def collect(self):
        return Collection(self.data)
    
    def string(self):
        return String(self.data)
    
    def exists(self):
        return self.file.exists()
        
    def __str__(self):
        return str(self.data)
    
    def __iter__(self):
        return iter(self.data)
    
    def __getitem__(self, key):
        return self.data[key]
    
    def __setitem__(self, key, value):
        self.data[key] = value
        self.save()
    
    def __repr__(self):
        return f"{self.__class__.__name__}({self.path}, format={self.format}), data={self.data}"