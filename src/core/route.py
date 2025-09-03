from src.core import Path
class Route:
    data = {}
    routes = {} 
    history = []
    
    @classmethod
    def register(cls, uri: Path, action, **kwargs): 
        kwargs = {**cls.data, **kwargs}

        prefix = kwargs.get("prefix") or cls.data.get("prefix")
        uri = Path(uri, prefix=prefix)
        middleware = ['app'] + kwargs.get("middleware", [])

        cls.routes[uri.get()] = {
            "uri": uri.get(),
            "action": action, 
            "name": kwargs.get("name", uri.name()),
            "method": kwargs.get("method", "GET").upper(),
            "middleware": middleware,
            "controller": kwargs.get("controller"), 
            # "description": kwargs.get("description"),
            # "tags": kwargs.get("tags", []), 
        }   

        return cls
    
    @classmethod
    def get(cls, uri: str, action, **kwargs):
        return cls.register(uri, action, method="GET", **kwargs)

    @classmethod
    def post(cls, uri: str, action, **kwargs):
        return cls.register(uri, action, method="POST", **kwargs)

    @classmethod
    def put(cls, uri: str, action, **kwargs):
        return cls.register(uri, action, method="PUT", **kwargs)

    @classmethod
    def patch(cls, uri: str, action, **kwargs):
        return cls.register(uri, action, method="PATCH", **kwargs)

    @classmethod
    def delete(cls, uri: str, action, **kwargs):
        return cls.register(uri, action, method="DELETE", **kwargs)
    @classmethod
    def options(cls, uri, action, **kwargs):
        return cls.register(uri, action, method="OPTIONS", **kwargs)

    @classmethod
    def head(cls, uri, action, **kwargs):
        return cls.register(uri, action, method="HEAD", **kwargs)

    @classmethod
    def trace(cls, uri, action, **kwargs):
        return cls.register(uri, action, method="TRACE", **kwargs)

    @classmethod
    def connect(cls, uri, action, **kwargs):
        return cls.register(uri, action, method="CONNECT", **kwargs)

    # Méthode pour plusieurs méthodes HTTP
    @classmethod
    def any(cls, uri, action, methods=None, **kwargs):
        if methods is None:
            methods = ["GET", "POST", "PUT", "PATCH", "DELETE", "OPTIONS", "HEAD", "TRACE", "CONNECT"]
        for method in methods:
            cls.register(uri, action, method=method.upper(), **kwargs)
        return cls
    
    @classmethod
    def resource(cls, name: str, controller, **kwargs):
        actions = {
            "index":   {"method": "GET",    "uri": f"/{name}"},
            "create":  {"method": "GET",    "uri": f"/{name}/create"},
            "store":   {"method": "POST",   "uri": f"/{name}"},
            "show":    {"method": "GET",    "uri": f"/{name}/<id>"},
            "edit":    {"method": "GET",    "uri": f"/{name}/<id>/edit"},
            "update":  {"method": "PUT",    "uri": f"/{name}/<id>"},
            "destroy": {"method": "DELETE", "uri": f"/{name}/<id>"},
        }
        for action, meta in actions.items():
            cls.register(
                uri=meta["uri"],
                action=action,
                controller=controller,
                name=f"{name}.{action}",
                method=meta["method"],
                **kwargs
            )
        return cls
    
    @classmethod
    def group(cls, callback, **kwargs):
        data = cls.data.copy()
        cls.data.update(kwargs)   
        callback()
        cls.data = data

    @classmethod
    def controller(cls, controller, callback, **kwargs):
        data = cls.data.copy()
        cls.data.update({"controller": controller, **kwargs})
        callback()
        cls.data = data 

    @classmethod
    def list(cls):
        return cls.routes
    
    @classmethod
    def resolve(cls, name: str): 
        for uri, meta in cls.routes.items():
            if meta.get("name") == name:
                return meta
        return None

    @classmethod
    def dispatch(cls, name: str, **kwargs):  
        route:dict = cls.resolve(name)
        if not route: 
            raise ValueError(f"Route '{name}' not found")
        
        action = route.get("action")
        controller = route.get("controller")
        middlewares = route.get("middleware", []) 
 
        def handler():
            if callable(action):
                return action
            
            elif controller and hasattr(controller, action):
                return getattr(controller, action)
            else:
                raise ValueError(f"invalide action for route '{name}'") 
        from src.middlewares.middleware import Middleware 
        return Middleware.run(middlewares, handler, kwargs) 
        
    @classmethod
    def clear(cls):
        cls.routes.clear()
        cls.history.clear() 

    @classmethod
    def log(cls, uri: str):
        cls.history.append(uri)
