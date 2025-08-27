

class Request:
    data = {}  
    protected = ['data', 'session', 'validator', 'user']

    def __init__(self, data:dict={}, **kwargs):
        from src.core import Session, Response
        
        from src.validators import Validator

        self.data = data 
        self.user = None
        self.session:Session = kwargs.get("session", None)
        self.validator:Validator = kwargs.get("validator", None)  
        self.session:Session = kwargs.get("session", None)
        self.response = Response(self.data)

    def send(self):
        return self.response

    def get(self, key):
        return self.data.get(key)

    def set(self, key, value):
        self.data[key] = value
    
    def all(self):
        return self.data

    def validate(self, validation: dict) -> bool:
        if self.validator.validate(validation, self.data):
            return True
        self.session.error(*self.validator.errors)   
        return False
    
    def has(self, key: str) -> bool:
        return key in self.data
    
    def only(self, *keys) -> dict:
        return {key: self.data[key] for key in keys if key in self.data}
    
    def ingore(self, *keys) -> dict:
        return {key: value for key, value in self.data.items() if key not in keys}

    def update(self, data: dict):
        self.data.update(data)

    def pop(self, key, default=None):
        return self.data.pop(key, default)

    def new(self, data):   
        return Request(data)
    
    def __getattr__(self, key):  
        return self.data.get(key)
    
    def __setattr__(self, key, value): 
        if key in self.protected:

            self.__dict__[key] = value
        else:
            self.data[key] = value

    def __getitem__(self, key):
        return self.data[key]   

    def __setitem__(self, key, value):
        self.data[key] = value     

    def __delattr__(self, key):
        if key in self.protected:
            raise AttributeError(name=key)
        self.data.pop(key, None)