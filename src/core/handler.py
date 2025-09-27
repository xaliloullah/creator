from typing import Any
from src.console import Terminal
class Handle: 
     
    @classmethod
    def request(cls, request):
        from src.core import Middleware 
        # action:Any = route.get("action")
        # controller = route.get("controller")
        # middlewares = route.get("middleware", []) 
        # # kwargs
        # def handler():
        #     if callable(action):
        #         return action
            
        #     elif controller and hasattr(controller, action):
        #         return getattr(controller, action)
        #     else:
        #         raise ValueError(f"invalide action for route '{name}'")  
        # return Middleware.run(middlewares, handler, kwargs)  

    @classmethod
    def route(cls, route:dict, **kwargs):
        from src.core import Middleware 
        name:Any = route.get("name")
        action:Any = route.get("action")
        controller = route.get("controller")
        middlewares = route.get("middleware", []) 
        # kwargs
        def handler():
            if callable(action):
                return action
            
            elif controller and hasattr(controller, action):
                return getattr(controller, action)
            else:
                raise ValueError(f"invalide action for route '{name}'")  
        return Middleware.run(middlewares, handler, kwargs) 

    @staticmethod
    def exception(e:Exception): 
        raise Exception(Terminal.error(str(e)))