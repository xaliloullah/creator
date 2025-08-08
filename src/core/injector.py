class Injector:
    def __init__(self):
        self._dependencies = {}
        
    def __str__(self):
        return str(self._dependencies)

    def register(self, cls, instance=None): 
        self._dependencies[cls] = instance if instance else cls

    def update(self, cls, instance):
        self._dependencies[cls] = instance

    def inject(self, annotation): 
        if annotation in self._dependencies: 
            dependency = self._dependencies[annotation] 
            if isinstance(dependency, type):
                return dependency()
            return dependency
        return None
    
    def resolve(self, func, *args, **kwargs):
        from inspect import signature 
        sig = signature(func)
        for name, param in sig.parameters.items():
            if param.annotation != param.empty and name not in kwargs:
                dependency = self.inject(param.annotation)
                if dependency is not None:
                    kwargs[name] = dependency
                else:
                    raise Exception()   
        self.func = func
        self.args = args
        self.kwargs = kwargs  
        return self.func(*self.args, **self.kwargs)
         
    
    # def dispatch(self):
    #     self.func(*self.args, **self.kwargs)