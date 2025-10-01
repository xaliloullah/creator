from typing import Any
from src.console import Terminal 
from src.core import Request, Injector

class Handle:

    @classmethod
    def setup(cls, injector):
        cls.injector:Injector = injector 
        return cls 
     
    @classmethod
    def request(cls, request:Request):
        from routes.route import Route  
        action = request.action
        params = request.params
        cls.injector.register('request', request)
        route = Route.resolve(action)
        cls.route(route, request, **params)

        # Request(data=data)


    @classmethod
    def route(cls, route:dict, request:Request|None=None, **kwargs):
        from src.core import Middleware 
        name:Any = route.get("name")
        action:Any = route.get("action")
        controller = route.get("controller")
        middlewares = route.get("middleware", [])  
        def handler():
            if callable(action):
                return action
            
            elif controller and hasattr(controller, action):
                return getattr(controller, action)
            else:
                raise ValueError(f"invalide action for route '{name}'")  
        return Middleware.run(middlewares, handler, kwargs, request) 

    @staticmethod
    def exception(e:Exception): 
        raise Exception(Terminal.error(str(e)))