class Injector:
    dependencies = {}

    
    @classmethod
    def __str__(cls):
        return str(cls.dependencies)
    
    @classmethod
    def register(cls, name: str, value):
        cls.dependencies[name] = value
    
    @classmethod
    def update(cls, name: str, value):
        cls.dependencies[name] = value

    @classmethod
    def inject(cls, name: str):
        if name in cls.dependencies:
            dependency = cls.dependencies[name]
            if isinstance(dependency, type):
                return dependency()
            return dependency
        return None

    @classmethod
    def resolve(cls, func, **kwargs):
        from inspect import signature
        sig = signature(func)

        for name, param in sig.parameters.items():
            if name not in kwargs:
                dependency = cls.inject(name)
                if dependency is not None:
                    kwargs[name] = dependency
                else:
                    raise Exception(f"Dependency '{name}' not found")
        return func(**kwargs)
