from typing import Any
from src.core import Path, Task 


class View:
    data = {}
    history = [] 
    current = ""
    
    def __init__(self, path:Path|str, **kwargs):
        try: 
            view = self.path(path) 
            self.share(**kwargs)
            self.set_history(view)
            self.show(view)
        except Exception as e:
            raise Exception(e) 
            
    @staticmethod
    def include(view:str, *args): 
        args if args else None
        return View.show(View.path(view))  
    
    @staticmethod
    def show(view:Path|str):  
        return Task.run(View.path(view), "view")
    
    @staticmethod
    def path(path):
        return path if isinstance(path, Path) else Path.views(path)

    @classmethod   
    def get(cls, key):
        return cls.data.get(key)

    @classmethod
    def set(cls, key, value):
        cls.data[key] = value 

    @classmethod   
    def get_history(cls):
        return cls.history

    @classmethod
    def set_history(cls, arg):
        cls.current = str(arg)
        cls.history.append(arg)

    @classmethod
    def share(cls, **kwargs):
        for key, value in kwargs.items():
            cls.set(key, value)
            
    @classmethod
    def back(cls):
        if len(cls.history) > 1:  
            cls.history.pop()   
            previous = cls.history[-1]
            cls.show(previous)

    @classmethod
    def current_view(cls):
        return cls.current
    
    @classmethod
    def previous(cls):
        if len(cls.history) > 1:
            return cls.history[-2]
        return None

    @classmethod
    def section(cls, key, value=None)->Any:  
        def decorator(function):
            def wrapper(*args, **kwargs):
                if value: 
                    cls.set(key, value)
                    return function(*args, **kwargs)  
                else:
                    cls.set(key, {'action': function, 'args': args, 'kwargs': kwargs}) 
                    return
            return wrapper
        return decorator

    @classmethod
    def extend(cls, path): 
        def decorator(function):
            def wrapper(*args, **kwargs):  
                function(*args, **kwargs)
                cls.show(path) 
                return 
            return wrapper 
        return decorator

    @classmethod
    def generate(cls, name):  
        result = cls.get(name)  
        if isinstance(result, dict): 
            return result['action'](*result['args'], **result['kwargs']) 
        elif result:   
            return result
        else:
            return ""  

