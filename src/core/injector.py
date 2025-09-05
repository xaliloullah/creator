class Injector:
    def __init__(self):
        self.dependencies = {}

    def __str__(self):
        return str(self.dependencies)

    def register(self, name: str, value):
        self.dependencies[name] = value

    def update(self, name: str, value):
        self.dependencies[name] = value

    def inject(self, name: str):
        if name in self.dependencies:
            dependency = self.dependencies[name]
            if isinstance(dependency, type):
                return dependency()
            return dependency
        return None

    def resolve(self, func, **kwargs):
        from inspect import signature
        sig = signature(func)

        for name, param in sig.parameters.items():
            if name not in kwargs:
                dependency = self.inject(name)
                if dependency is not None:
                    kwargs[name] = dependency
                else:
                    raise Exception(f"Dependency '{name}' not found")
        return func(**kwargs)
