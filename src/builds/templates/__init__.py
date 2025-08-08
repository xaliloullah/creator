from src.core import Storage, Path

class Template:
    def __init__(self, name: str):
        self.name = Path.template(name)
        self.content = Storage(self.name).read() 

    def render(self, **kwargs) -> str:
        return self.content.format(**kwargs)  