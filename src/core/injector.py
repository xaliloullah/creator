class Injector:
    def __init__(self):
        self.dependencies = {}
        
    def __str__(self):
        return str(self.dependencies)

    def register(self, cls, instance=None): 
        self.dependencies[cls] = instance if instance else cls

    def update(self, cls, instance):
        self.dependencies[cls] = instance

    def inject(self, annotation): 
        if annotation in self.dependencies: 
            dependency = self.dependencies[annotation] 
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
        return func(*args, **kwargs)
          