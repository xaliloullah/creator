from src.core import File, Path

class Storage:

    def __init__(self, path: str=None, **kwargs):  
        self.path = path if isinstance(path, Path) else Path(path)
        self.format = kwargs.get("format", None)
        self.default = kwargs.get("default", None)
        self.absolute = kwargs.get("absolute", False)  
        self.disk = kwargs.get("disk", None)  
        
        if self.absolute:
            self.path = Path.storage(self.path)

        self.file = File(self.path) 

        if not self.format:
            self.format = self.file.get_extension(with_dot=False) 
        self.file.set_extension(self.format)


    @property
    def data(self):
        return self.load() or self.default

    @data.setter
    def data(self, value):
        self.save(value) 

    def load(self, **kwargs):
        try:    
            self.file.path.ensure_exists()
            return self.file.load(format=self.format, **kwargs)
        except Exception as e:
            raise Exception(e)
    
    def save(self, data=None, **kwargs):  
        backup = self.load()
        format = kwargs.get("format", self.format)
        default = kwargs.get("default", self.default)
        try:     
            if data is None:
                data = self.data if self.data is not None else default
            self.file.save(data, format=format, **kwargs)

        except Exception as e:
            self.file.save(backup, format=self.format)   
            raise Exception(e) 
    
    def read(self):
        return self.data 
    
    def get(self):
        return self.data 
    
    def create(self, data): 
        self.data = data
        self.save() 
        return self
    
    def update(self, data):
        return self.create(data)

    def add(self, data):
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

    def exists(self):
        return self.file.exists()
        
    def __str__(self):
        return str(self.data)
    
    def __iter__(self):
        return iter(self.data)
    
    def __getitem__(self, key):
        return self.data[key]
    
    def __setitem__(self, value):
        self.data = value
    
    def __repr__(self):
        return f"{self.__class__.__name__}({self.path}, format={self.format}), data={self.data}"