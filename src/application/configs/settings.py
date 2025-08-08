from src.core import Path, File, Storage, Task, Date
import os
import sys

class Settings:
    path = Path.settings()   
    storage = Storage(path, format="json", default={})
    
    @classmethod
    def setup(cls):
        try:  
            cls.settings = cls.load()
            cls.settings["name"] = "creator"
            cls.settings["version"] = "1.0.0"
            cls.settings["author"] = "Ibrahima Khaliloullah Thiam"
            cls.settings["description"] = "Creator is a versatile Python framework designed to streamline the development process by providing a comprehensive set of tools and libraries. It supports various databases including MySQL, PostgreSQL, and MongoDB, and offers functionalities for encryption, argument parsing, keyboard interactions, markdown processing, YAML parsing, PDF manipulation, and image processing. The framework is built to be compatible with Python 3.12.4 and includes a wide range of packages to facilitate rapid application development." 
            cls.settings["langs"] = ['en']
            cls.settings["supported_database"] = {
                "sqlite": "SQLite",
                "mysql": "MySQL",
                # "postgresql": "PostgreSQL",
                # "mongodb": "MongoDB",
                # "oracle": "Oracle",
                # "mssql": "Microsoft SQL Server",
            } 
            cls.settings["python"] = f"{sys.version.split()[0]}"
            cls.settings["packages"] = File(Path.requirements()).load(format="json")
            cls.settings["created_at"] = "2024-09-22 00:00:00.000000"
            cls.settings["updated_at"] = f"{Date.now()}"
            cls.save()
        except Exception as e:
            raise Exception(e) 
         
    @classmethod 
    def update(cls):
        try:     
            # cls.update_requirements()
            cls.settings["python"] = f"{sys.version.split()[0]}"
            cls.settings["packages"] = File(Path.requirements()).load(format="json")
            cls.settings["updated_at"]=f"{Date.now()}" 
            cls.vscode()
            cls.make_architecture(all=True)
            cls.save()
        except Exception as e:
            raise Exception(e) 
        
    @classmethod
    def get(cls, key, default=None):
        cls.settings = cls.load()
        if key in cls.settings:
            return cls.settings[key]
        else:
            return default
        
    @classmethod
    def set(cls, key, value): 
        cls.settings = cls.load()
        # if key in cls.settings:
        cls.settings[key] = value  
        
    @classmethod
    def load(cls):
        return File(cls.path).load(format="json") 
        
    @classmethod
    def save(cls):
        backup = cls.load()
        try:
            File(cls.path).save(cls.settings, format="json", indent=2)
        except Exception as e:
            File(cls.path).save(backup, format="json", indent=2) 
            raise
        
    @classmethod
    def install_packages(cls): 
        for package, version in cls.settings["packages"].items(): 
            Task.install(package, version=version)
    
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

    # def publish_routes(path=Path.routes): 
    #     File.copy_files('utils/creator/src/build/routes/', path) 

    # def publish_views(path=Path.resources): 
    #     File.copy_folders('utils/creator/src/build/resources/', path) 

        
    @staticmethod
    def create_venv(path=Path.environment("python")):
        try:
            if not File(path).exists(): 
                File(path).ensure_exists()
                Task.execute("venv", path)
                print(f"Virtual environment created at {path}")
        except Exception as e:
            raise Exception(e) 
        
    @staticmethod
    def activate_venv(path=Path.environment("python")): 
        if os.name == 'nt':
            script = Path(path).join("Scripts", "Activate.ps1")
        else:
            script = Path(path).join("bin", "activate")
            
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