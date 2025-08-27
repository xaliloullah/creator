from src.core import Path, File, Storage, Task, Date
import os
import sys

class Settings: 
    path = Path.settings()   
    storage = Storage(path, format="json", default={})
    
    @classmethod
    def setup(cls):
        try:  
            cls.data = cls.load()
            cls.data["name"] = "creator"
            cls.data["version"] = "1.0.0" 
            cls.data["langs"] = ['en']
            cls.data["databases"] = {
                "sqlite": "SQLite",
                "mysql": "MySQL",
                # "postgresql": "PostgreSQL",
                # "mongodb": "MongoDB",
                # "oracle": "Oracle",
                # "mssql": "Microsoft SQL Server",
            } 
            cls.data["python"] = f"{sys.version.split()[0]}"
            cls.data["packages"] = {
                "mysql-connector-python": "9.0.0",
                "psycopg2": "2.9.10",
                "pymongo": "4.10.1",
                "cryptography": "44.0.0",
                "bcrypt": "4.2.1",
                "argparse": "1.4.0",
                "keyboard": "0.13.5",
                "markdown": "3.7",
                "pyyaml": "6.0.2",
                "PyPDF2": "3.0.1",
                "pillow": "11.1.0",
                "deep-translator": "1.11.4",
                # "PyQt5": "5.15.11",
                "pyttsx3": "2.99"
                }
            cls.data["created_at"] = "2024-09-22 00:00:00.000000"
            cls.data["updated_at"] = f"{Date.now()}"
            cls.save()
        except Exception as e:
            raise Exception(e) 
         
    @classmethod 
    def update(cls, force=False):
        try:       
            cls.update_packages()
            cls.data["python"] = f"{sys.version.split()[0]}" 
            cls.data["updated_at"]=f"{Date.now()}" 
            cls.vscode()
            cls.make_architecture(all=True)
            cls.save()
        except Exception as e:
            raise Exception(e) 
        
    @classmethod 
    def refresh(cls):
        try:         
            cls.vscode()
            cls.make_architecture(all=True)
            cls.save()
        except Exception as e:
            raise Exception(e) 
        
    @classmethod
    def get(cls, key, default=None):
        cls.data = cls.load()
        if key in cls.data:
            return cls.data[key]
        else:
            return default
        
    @classmethod
    def set(cls, key, value): 
        cls.data = cls.load() 
        cls.data[key] = value  
        
    @classmethod
    def load(cls):
        return File(cls.path).load(format="json") 
        
    @classmethod
    def save(cls):
        backup = cls.load()
        try:
            File(cls.path).save(cls.data, format="json", indent=2)
        except Exception as e:
            File(cls.path).save(backup, format="json", indent=2) 
            raise
        
    @classmethod
    def install_packages(cls): 
        for package, version in cls.data["packages"].items(): 
            Task.install(package, version=version)

    @classmethod
    def uninstall_packages(cls): 
        for package, version in cls.data["packages"].items(): 
            Task.uninstall(package)
            
    @classmethod
    def update_packages(cls): 
        for package, version in cls.data["packages"].items(): 
            Task.install(package)
        
    @staticmethod
    def install_requirements(path=Path.requirements()):
        requirements = File(path).load(format="json") 
        for package, version in requirements.items(): 
            Task.install(package,  version=version) 

    @staticmethod
    def update_requirements(path=Path.requirements()):
        requirements = File(path).load(format="json")  
        for package, version in requirements.items(): 
            Task.install(package) 

    def cache(**kwargs):
        source=kwargs.get('source', None)
        destination=kwargs.get('destination', None)
        mode=kwargs.get('mode', "default")
        # Cache.make(source, destination, mode)  
    
    # def backup(source, destination):
    #     pass
    
    @staticmethod
    def make_architecture(**kwargs):
        ignore:list = kwargs.get("ignore", []) 
        all = kwargs.get("all", False) 
        
        if '__pycache__' not in ignore:
            ignore.append('__pycache__')
        if '.vscode' not in ignore:
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
        try:
            if not File(path).exists(): 
                File(path).ensure_exists()
                Task.execute("venv", path.get())
                print(f"Virtual environment created at {path}")
        except Exception as e:
            raise Exception(e) 
        
    @staticmethod
    def activate_venv(path=Path.environment("python")): 
        if os.name == 'nt':
            script = Path(path).join("Scripts/Activate.ps1")
        else:
            script = Path(path).join("bin/activate")
            
        if File(script).exists():
            script = File(script).path.absolute()
            if os.name == 'nt':
                os.system(f'cmd /k "{script}"')
            else:
                os.system(f'bash -c "{script}"')
            print(f"Virtual environment activated at {path}")
        # else: 
        #     Settings.create_venv()
        #     Settings.activate_venv() 

    @staticmethod
    def deactivate_venv():
        if os.name == 'nt':
            script = "deactivate"
        else:
            script = "deactivate"
        
        os.system(script)
        print("Virtual environment deactivated")


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