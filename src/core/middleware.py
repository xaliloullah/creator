from typing import Any, Callable
from src.core import Request


class Middleware:
    data: dict[str, 'Middleware'] = {}
    cache = None

    @staticmethod
    def handle(request:Request, next: Callable, params:Any=None) -> Any:
        raise NotImplementedError("Middleware must implement the handle method.")
    
    @classmethod
    def setup(cls):
        if cls.cache is None:
            try:
                from config import middleware
                cls.cache = middleware
            except ImportError:
                raise ImportError("middleware module not found. Please ensure that the middleware are properly defined and imported.")
        return cls.cache
        
    @classmethod
    def register(cls, name: str, middleware: 'Middleware') -> None: 
        cls.data[name] = middleware
        
    @classmethod
    def get(cls, name:str) -> Any:
        return cls.data.get(name)  
    
    @classmethod
    def list(cls):
        return list(cls.data.keys())

    @classmethod
    def run(cls, middlewares, handler, kwargs={}):   
        from main import Creator
        cls.setup()
        def execute(index:int, request): 
            if index >= len(middlewares): 
                return Creator.injector.resolve(handler(), **kwargs)
            name:str = middlewares[index]
            params:str|Any = None
            if ":" in name:
                name, params = name.split(":", 1)
            middleware:Middleware = cls.get(name)
            if not middleware:
                raise ValueError(f"Middleware {name} not found")
            next = lambda req: execute(index + 1, req)
            if params:
                return middleware.handle(request, next, params)
            else:
                return middleware.handle(request, next)
        return execute(0, Creator.request)