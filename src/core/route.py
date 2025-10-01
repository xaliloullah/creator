from typing import Any
from src.core import Path

class Route:
    data = {}
    routes = {} 
    history = []
    active = ()
    
    @classmethod
    def register(cls, uri:Path|str, action, **kwargs): 
        kwargs = {**cls.data, **kwargs}
        prefix = kwargs.get("prefix") or cls.data.get("prefix")
        uri = Path(uri, prefix=prefix)
        middleware = ['app', *kwargs.get("middleware", [])]
        method:str = kwargs.get("method", "GET")
        name = kwargs.get("name", uri.name())
        cls.routes[name] = {
            "uri": uri.get(),
            "name": name,
            "method": method.upper(),
            "action": action, 
            "controller": kwargs.get("controller"),
            "middleware": middleware,
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
            "index":{"method": "GET", "uri": f"/{name}"},
            "create": {"method": "GET", "uri": f"/{name}/create"},
            "store":{"method": "POST", "uri": f"/{name}"},
            "show": {"method": "GET", "uri": f"/{name}/<id>"},
            "edit": {"method": "GET", "uri": f"/{name}/<id>/edit"},
            "update": {"method": "PUT", "uri": f"/{name}/<id>"},
            "destroy": {"method": "DELETE", "uri": f"/{name}/<id>"},
        }
        for action, meta in actions.items():
            cls.register(
                name=f"{name}.{action}",
                uri=meta["uri"],
                action=action,
                controller=controller,
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
    def resolve(cls, value, key="name", **kwargs): 
        for _, meta in cls.routes.items():
            if meta.get(key) == value:
                cls.active = value, kwargs
                cls.log(cls.active)
                return meta
        raise ValueError(f"Route '{value}' not found")  
     
    @classmethod
    def clear(cls):
        cls.routes.clear()
        cls.history.clear() 

    @classmethod
    def log(cls, route: tuple):
        cls.history.append(route)

    @classmethod
    def current(cls) -> Any:
        return cls.active
    
    @classmethod
    def previous(cls) -> Any:
        if len(cls.history) > 1:
            return cls.history[-2]
        return None
