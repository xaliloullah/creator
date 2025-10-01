from typing import Any

from regex import R

class Request: 
    protected = ['data', 'session', 'response', 'validator', 'user']

    def __init__(self, **kwargs):
        from src.core import Session, Response
        from src.validators import Validator

        self.data = kwargs 
        self.session = Session() 
        self.response:Response = Response()
        self.validator = Validator() 
        self.user = None

    def all(self):
        return self.data
    
    def send(self, action, **kwargs):
        self.action = action
        self.params = kwargs 
        from main import Creator
        from src.core import Response
        self.response:Response = Response(Creator.handle.request(self))


        return self.response

    def get(self, key):
        return self.data.get(key)

    def set(self, key, value):
        self.data[key] = value
    
    def validate(self, validation: dict) -> bool:
        if self.validator.validate(validation, self.data):
            return True
        self.session.error(*self.validator.get_errors())   
        return False
    
    def has(self, key: str) -> bool:
        return key in self.data
    
    def only(self, *keys) -> dict:
        return {key: self.data[key] for key in keys if key in self.data}
    
    def ignore(self, *keys) -> dict:
        return {key: value for key, value in self.data.items() if key not in keys}

    def update(self, data: dict):
        self.data.update(data)

    def pop(self, key, default=None):
        return self.data.pop(key, default)

    def new(self, **data):  
        Request(**data) 
        return self
    
    # -----------------------
    # Magic methods
    # -----------------------
    def __getitem__(self, key):
        return self.data[key]   

    def __setitem__(self, key, value):
        self.data[key] = value     

    def __getattr__(self, key: str) -> Any:  
        if key in self.data:
            return self.data.get(key)
        raise AttributeError(f"'Request' object has no attribute '{key}'")
    
    def __setattr__(self, key: str, value: Any): 
        if key in self.protected:
            self.__dict__[key] = value
        else:
            self.data[key] = value

    def __delattr__(self, key: str) -> None:
        if key in self.protected:
            raise AttributeError(f"Cannot delete protected attribute '{key}'")
        self.data.pop(key, None)

    def __contains__(self, key: str) -> bool:
        return key in self.data.keys()

    def __iter__(self):
        return iter(self.data.keys())

    def __len__(self) -> int:
        return len(self.data.keys()) 
    
    def __repr__(self) -> str:
        return f"<Request {self.data}>"
    
    def __call__(self, **kwargs: Any) -> 'Request':
        return Request(**kwargs)