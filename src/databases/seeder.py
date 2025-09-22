from src.builds import Build
from src.console import Terminal 
from src.core import File, Path, Task

class Seeder:
    path = Path.seeds()
    file = File(path)  

    def __init__(self, name=None):
        self.name = name

    def create(self):
        try: 
            self.file.path.seeds(self.name)
            self.file.save(Build.seed(self.name))
            Terminal.success(f"Seed {self.file.name} created successfully.")
        except Exception as e:
            Terminal.error(f"{e}") 
            exit()

    @classmethod
    def get(cls):
        try:
            seeds = cls.file.list(endswith=".py")
            seeds = [seed.replace(".py", "") for seed in seeds]          
            return sorted(seeds) 
        except Exception as e: 
            Terminal.error(f"{e}") 
            exit()

    @classmethod
    def run(cls, name, action='up'): 
        try:
            Terminal.info(f"Applying seed '{name}'.")
            path = cls.file.path.seeds(name)
            Task.run(path, action) 
        except Exception as e:
            Terminal.error(f"{e}") 
            exit()

    @classmethod
    def seed(cls, run='up'):  
        alert = {}
        try:
            if run == 'up': 
                seeds = cls.get() 
                if seeds:
                    for seed in seeds:   
                        cls.run(seed, "up")  
                    alert = {'success': 'seeds applied successfully.'}
                else:
                    alert = {'warning': 'Nothing to seed...'} 
            if alert:
                for type, message in alert.items():
                    if type == 'success':
                        Terminal.success(message)
                    elif type == 'warning':
                        Terminal.warning(message)
                    elif type == 'error':
                        Terminal.error(message)
                    elif type == 'info':
                        Terminal.info(message)
                    else:
                        Terminal.error(f"Unknown message type: {type}, Message: {message}")

        except Exception as e:
            Terminal.error(f"{e}") 
            exit()
        
                