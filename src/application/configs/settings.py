from src.core import Path, File, Task
from src.core import Structure
import os 

class Settings(Structure): 

    def __init__(self):  
        self.path = Path.settings()
        super().__init__(self.path)

    # @classmethod
    # def create(cls):
    #     try:  
    #         cls.data = cls.load()
    #         cls.data["name"] = "creator"
    #         cls.data["version"] = "1.0.0" 
    #         cls.data["langs"] = ['en']
    #         cls.data["databases"] = {
    #             "sqlite": "SQLite",
    #             "mysql": "MySQL",
    #             "postgresql": "PostgreSQL",
    #             "sqlserver": "Microsoft SQL Server",
    #             "mongodb": "MongoDB",
    #             # "oracle": "Oracle",
    #         } 
    #         cls.data["python"] = f"{sys.version.split()[0]}"
    #         cls.data["packages"] = {
    #             "mysql-connector-python": "9.0.0",
    #             "psycopg2": "2.9.10",
    #             "pymongo": "4.10.1",
    #             "cryptography": "44.0.0",
    #             "bcrypt": "4.2.1",
    #             "argparse": "1.4.0",
    #             "keyboard": "0.13.5",
    #             "markdown": "3.7",
    #             "pyyaml": "6.0.2",
    #             "PyPDF2": "3.0.1",
    #             "pillow": "11.1.0",
    #             "deep-translator": "1.11.4", 
    #             "pyttsx3": "2.99"
    #             }
    #         cls.data["created_at"] = "2024-09-22 00:00:00"
    #         cls.data["updated_at"] = f"{Date.now()}"
    #         cls.save()
    #     except Exception as e:
    #         raise Exception(e) 
         
    def install_packages(self): 
        for package, version in self.get("packages").items(): 
            Task.install(package, version=version, venv=self.get('venv', False))
 
    def uninstall_packages(self): 
        for package in self.get("packages"): 
            Task.uninstall(package)
             
    def update_packages(self): 
        for package in self.get("packages"): 
            Task.install(package, venv=self.get('venv', False))
            
    @staticmethod
    def vscode(path = Path.vscode()):
        try:  
            settings = File(path).ensure_exists().load(format="json")
            
            settings["files.associations"] = {
                "*.cre": "python",
                "creator": "python"
            }
            File(path).save(settings, format="json", indent=2)
        except Exception as e:
            raise Exception(e)
        
    @staticmethod
    def make_architecture(**kwargs):
        ignore:list = kwargs.get("ignore", []) 
        all = kwargs.get("all", False) 
        
        ignore.append('__pycache__')
        ignore.append('.vscode')
        ignore.append('python')
        ignore.append('.git')
        if not all:
            ignore.append('src')

        File(Path.architecture()).save(File.make_structure(ignore=ignore))

    def publish(path, destination):
        File(path).copy(destination)  
         
    @staticmethod
    def create_venv(path=Path.environment("python")):
        path = Path(path)
        try:
            if not File(path).exists(): 
                File(path).ensure_exists(folder=True)
                Task.execute("venv", path.get())
                print(f"Virtual environment created at {path}")
        except Exception as e:
            raise Exception(e) 
 
    def activate_venv(self, path=Path.environment("python").absolute()): 
        self.set("venv", True)   
        if os.name == "nt":  # Windows
            activate = path.join("Scripts\\activate.bat")
        else:  # macOS / Linux
            activate = path.join("bin/activate")
        Task.execute(activate, shell=True)
 
    def deactivate_venv(self, path=Path.environment("python").absolute()):
        self.set("venv", False)    
        if os.name == "nt":  # Windows
            deactivate = path.join("Scripts\\deactivate.bat")
        else:  # macOS / Linux
            deactivate = path.join("bin/deactivate") 
        Task.execute(deactivate, shell=True)


    @classmethod
    def env(cls):
        return Structure(Path.env(), format='env', default={})