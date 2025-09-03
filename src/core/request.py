class Request:
    params = {}  
    protected = ['params', 'session', 'validator', 'user']

    def __init__(self, params:dict={}, **kwargs):
        from src.core import Session, Response
        from src.validators import Validator

        self.params = params 
        self.session:Session = kwargs.get("session", None)
        self.validator:Validator = kwargs.get("validator", None)  
        self.response = Response(self.params)
        self.user = None

    def all(self):
        return self.params
    
    def send(self):
        return self.response

    def get(self, key):
        return self.params.get(key)

    def set(self, key, value):
        self.params[key] = value
    
    def validate(self, validation: dict) -> bool:
        if self.validator.validate(validation, self.params):
            return True
        self.session.error(*self.validator.errors)   
        return False
    
    def has(self, key: str) -> bool:
        return key in self.params
    
    def only(self, *keys) -> dict:
        return {key: self.params[key] for key in keys if key in self.params}
    
    def ignore(self, *keys) -> dict:
        return {key: value for key, value in self.params.items() if key not in keys}

    def update(self, params: dict):
        self.params.update(params)

    def pop(self, key, default=None):
        return self.params.pop(key, default)

    def new(self, params):   
        return Request(params)
    
    def __getattr__(self, key):  
        return self.params.get(key)
    
    def __setattr__(self, key, value): 
        if key in self.protected:
            self.__dict__[key] = value
        else:
            self.params[key] = value

    def __getitem__(self, key):
        return self.params[key]   

    def __setitem__(self, key, value):
        self.params[key] = value     

    def __delattr__(self, key):
        if key in self.protected:
            raise AttributeError(name=key)
        self.params.pop(key, None) 