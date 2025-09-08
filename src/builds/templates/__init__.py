from src.core import Storage, Path, String

class Template:
    def __init__(self, name: str):
        self.name = Path.template(name)
        self.content = Storage(self.name, absolute=False).load()

    def render(self, **kwargs) -> str:
        return String(self.content.format(**kwargs))  