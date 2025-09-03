from main import Creator

class Middleware:
    data = {}
    cache = None

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
    def register(cls, name:str, middleware): 
        cls.data[name] = middleware

    @classmethod
    def get(cls, name:str):  
        return cls.data.get(name)  
    
    @classmethod
    def list(cls):
        return list(cls.data.keys())

    @staticmethod
    def handle(request, next, params=None):
        raise NotImplementedError("Middleware must implement the handle method.")

    @classmethod
    def run(cls, middlewares, handler, kwargs={}):   
        cls.setup()
        def execute(index=0): 
            if index >= len(middlewares): 
                return Creator.injector.resolve(handler(), **kwargs)
 
            name:str = middlewares[index]
            params:str = None
            if ":" in name:
                name, params = name.split(":", 1)
            middleware:Middleware = cls.get(name)
            if not middleware:
                raise ValueError(f"Middleware {name} not found")

            if params is not None:
                return middleware.handle(Creator.request, lambda: execute(index + 1), params)
            else:
                return middleware.handle(Creator.request, lambda: execute(index + 1))
        return execute()