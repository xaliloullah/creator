from typing import Any
from src.builds.templates import Template
from src.core import String, Path
class Build:

    @staticmethod
    def creator():
        return Template("creator").render()
    
    @staticmethod   
    def importing(packages, *modules, alias: str|Any = None) -> str:
        try: 
            package = Path(packages, separator='.')
            if modules:
                imported = f"from {package} import {', '.join(module for module in [*modules])}" 
            else:  
                parts = package.parts('.')
                if len(parts) > 1:
                    package = '.'.join(parts[:-1])
                    module = parts[-1]
                    imported = f"from {package} import {module}"
                else: 
                    imported = f"import {package}"
                if alias:
                    imported+=f" as {alias}"
            return imported
        except Exception as e:
            raise Exception(e)
    
    @staticmethod
    def model(name: str, table: str, driver:str):
        if driver in ["file", "structure", ]:
            return Template("models.structure").render(name=name, table=table)
        return Template("models.model").render(name=name, table=table)
      
    @staticmethod
    def controller(name:str, model:Any|str=None, resource: bool=False):
        render = ""
        if model:
            render += Template("controllers.model").render(model=String(model).snakecase(), Model=String(model).pascalcase())
        render += Template("controllers.controller").render(name=name)
        if resource:
            render += Template("controllers.resource").render()
        return render

    @staticmethod   
    def command(name: str):
        return Template("command").render(name=name)

    @staticmethod
    def migration(name: str):
        return Template("migration").render(name=name) 
    
    @staticmethod
    def seed(name: str):
        return Template("seed").render(name=name) 

    @staticmethod
    def test(name: str):
        return Template("test").render(name=name) 
    
    @staticmethod
    def event(name: str):
        return Template("event").render(name=name) 
    
    @staticmethod
    def middleware(name: str):
        return Template("middleware").render(name=name)  
        
    class Env:
        @staticmethod
        def app(**kwargs):
            name = kwargs.get("name", "creator")
            key = kwargs.get("key", False)
            lang = kwargs.get("lang", "en")
            mode = kwargs.get("mode", "console")
            host = kwargs.get("host", "127.0.0.1")
            port = kwargs.get("port", "5000")
            debug = kwargs.get("debug", False)
            return Template("env.app").render(name=name, key=key, lang=lang, host=host, port=port, mode=mode, debug=debug)

        @staticmethod
        def database(**kwargs):
            name = kwargs.get("name", "creator")
            path = kwargs.get("path", "databases")
            driver = kwargs.get("driver", "sqlite")

            render = Template("env.databases.database").render(path=path)
            if driver == "sqlite":
                render += Template("env.databases.sqlite").render(name=name)
            elif driver == "mysql":
                render += Template("env.databases.mysql").render(name=name, path=path, port="3306")
            elif driver == "postgresql":
                render += Template("env.databases.postgresql").render(name=name, path=path, port="5432")
            elif driver == "sqlserver":
                render += Template("env.databases.sqlserver").render(name=name, path=path, port="1433")
            return render

        @staticmethod
        def session(**kwargs):
            name = kwargs.get("name", "session")
            driver = kwargs.get("driver", "file")
            lifetime = kwargs.get("lifetime", 30)
            return Template("env.session").render(name=name, driver=driver, lifetime=lifetime)
        
    class View:
        @staticmethod
        def index(name=None):  
            return Template("views.resources.index").render(name=name)
        
        @staticmethod
        def create(name=None):   
            return Template("views.resources.create").render(name=name)
        @staticmethod
        def edit(name=None):  
            return Template("views.resources.edit").render(name=name) 
        @staticmethod
        def view(name=None):  
            return Template("views.resources.view").render(name=name)
           
        @staticmethod
        def default(name):
            return Template("views.default").render(name=name)
        
        @staticmethod
        def app(name):
            return Template("views.app").render(name=name)
        
        @staticmethod
        def main(name):
            return Template("views.main").render(name=name)
        
        @staticmethod
        def dashboard(name):
            return Template("views.dashboard").render(name=name)
        
    @staticmethod
    def readme(**kwargs):
        name = kwargs.get("name") 
        logo = kwargs.get("logo") 
        description = kwargs.get("description")  
        return Template('readme').render(name=name, logo=logo, description=description)
        
        