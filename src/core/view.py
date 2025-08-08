from src.core import Path, File, Task 


class View:
    data = {}
    history = [] 
    


    def __init__(self, path:str=None, *args):
        try: 
            view = self.path(path)
            if args:
                args
            self.show(view)
            self.set_history(view)
        except Exception as e:
            raise Exception(e)
        # title: str = "",
        # width: int = 800,
        # height: int = 600,
        # template: str = None,
        # context: dict = None,
        # layout: str = None,
        # visible: bool = True,
        # style: dict = None,
        # events: dict = None 
            
    @staticmethod
    def include(view:str, *args): 
        args if args else None
        return View.show(View.path(view))  
    
    @staticmethod
    def show(view:str): 
        return Task.run(View.path(view), "render", "handle")
    
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
    def share(cls, data):
        cls.data.update(data)
        
    @classmethod   
    def get_history(cls):
        return cls.history

    @classmethod
    def set_history(cls, arg):
        cls.history.append(arg)

    @classmethod
    def compact(cls, **kwargs):
        for key, value in kwargs.items():
            cls.set(key, value)
            
    @classmethod
    def back(cls):
        if len(cls.history) > 1:  
            cls.history.pop()   
            previous = cls.history[-1]
            cls.show(previous)

    @classmethod
    def section(cls, key, value=None):  
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