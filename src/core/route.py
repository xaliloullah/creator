
class Route:
    data = {}
    routes = {} 
    history = []
    
    @classmethod
    def register(cls, name: str, action, **kwargs): 
        kwargs = {**cls.data, **kwargs}

        prefix = kwargs.get("prefix") or cls.data.get("prefix")
        if prefix:
            name = f"{prefix}.{name}" if name else prefix

        cls.routes[name] = {
            "action": action,
            "middleware": kwargs.get("middleware", []),
            "controller": kwargs.get("controller"),
            "roles": kwargs.get("roles"),
            "permissions": kwargs.get("permissions"),
            "description": kwargs.get("description"),
            "tags": kwargs.get("tags", []),
        }   

        return cls

    @classmethod
    def resource(cls, name: str, controller, **kwargs):
        actions = ["index", "create", "store", "show", "edit", "update", "destroy"]
        for action in actions:
            cls.register(f"{name}.{action}", controller=controller, action=action, **kwargs)
        return cls
    
    @classmethod
    def group(cls, callback, **kwargs):
        old_data = cls.data.copy()
        cls.data.update(kwargs)   
        callback()
        cls.data = old_data

    @classmethod
    def controller(cls, controller, callback, **kwargs):
        old_data = cls.data.copy()
        cls.data.update({"controller": controller, **kwargs})
        callback()
        cls.data = old_data
  
    @classmethod
    def get(cls, name):
        return cls.routes.get(name, None)

    @classmethod
    def list(cls):
        return cls.routes

    
    @classmethod
    def dispatch(cls, name: str, injector, **kwargs): 
        route:dict = cls.get(name)
        if not route: 
            raise ValueError(f"Route '{name}' not found")
        
        action = route.get("action")
        controller = route.get("controller")
        middlewares = route.get("middleware", []) 
 
        def handler():
            if callable(action):
                return injector.resolve(action, **kwargs)
            elif controller and hasattr(controller, action):
                return injector.resolve(getattr(controller, action), **kwargs)
            else:
                raise ValueError(f"Aucune action valide pour la route '{name}'")
            
        from src.middlewares.middleware import Middleware 
        return Middleware.run(middlewares, handler) 
        
    @classmethod
    def clear(cls):
        cls.routes.clear()
        cls.history.clear()

    @classmethod   
    def get_history(cls, name):
        return cls.history

    @classmethod
    def set_history(cls, name, kwargs):
        # cls.history.append(arg)
        cls.history.append({"name": name, "params": kwargs})

