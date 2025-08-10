from src.builds import Build
from src.console import Terminal 
from src.core import File, Path,Task

class Seeder:
    def __init__(self, name=None):
        self.name = name
        self.path = Path.seeds()
        self.file = File(self.path)  

    def create(self):
        try: 
            self.file.path.seeds(self.name)
            self.file.save(Build.seed(self.name))
            Terminal.success(f"Seed {self.file.name} created successfully.")
        except Exception as e:
            Terminal.error(f"{e}") 
            exit()

    def get(self):
        try:
            seeds = self.file.list(endswith=".py")       
            return sorted(seeds) 
        except Exception as e: 
            Terminal.error(f"{e}") 
            exit()

    def run(self, name, action='up'): 
        try:
            path = self.file.path.seeds(name)
            Task.run(path, action) 
        except Exception as e:
            Terminal.error(f"{e}") 
            exit()

    def seed(self, run='up'):  
        alert = {}
        try:
            if run == 'up': 
                seeds = self.get() 
                if seeds:
                    for seed in seeds: 
                        Terminal.info(f"Applying seed '{seed}'.")  
                        self.run(seed, "up")  
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
        
                