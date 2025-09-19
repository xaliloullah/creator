from src.core import File, Path, Task
from src.console import Terminal 


class Test:
    path = Path.tests()
    file = File(path) 

    def __init__(self, name=None):
        self.name = name 
             
    def run(self, action='test_*'): 
        path = Path(self.path).join(self.name)
        Terminal.info(f"Running test: {path}")
        try:
            Task.run(path, functions=[action])
            Terminal.success(f"Test succeeded: {path}")
        except Exception as e:
            Terminal.error(f"Error running test: {path} {e}") 

    @classmethod
    def get(cls, name=None):
        try:
            tests = cls.file.list(endswith=".py")       
            if name:
                from src.core import String
                name = Path(String(name).snakecase() , suffix=".py") 
                return name 
            return sorted(tests)
        except Exception as e: 
            Terminal.error(f"{e}") 
            exit(1) 