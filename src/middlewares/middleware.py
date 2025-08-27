class Middleware:
    data = {}

    @classmethod
    def setup(cls):
        try:
            from config import middleware
        except ImportError:
            raise ImportError("middleware module not found. Please ensure that the middleware are properly defined and imported.")

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
    def handle(args):
        raise NotImplementedError("Middleware must implement the handle method.")

    @classmethod
    def run(cls, middlewares, handler, request):   
        cls.setup()
        def execute(index=0):
            if index >= len(middlewares):
                return handler(request)
 
            name:str = middlewares[index]
            params:str = None
            if ":" in name:
                name, params = name.split(":", 1)
                params = params.split(",") 

            middleware:Middleware = cls.get(name)
            if not middleware:
                return f"Middleware {name} not found" 

            return middleware.handle(request, lambda: execute(index + 1), params)

        return execute()