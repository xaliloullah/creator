from src.builds.templates import Template
from src.core import Path
class Build:

    @staticmethod
    def creator():
        return Template("creator").render()
    
    @staticmethod
    def plu():
        pass

    @staticmethod
    def model(name: str, table: str):
        return Template("model").render(name=name.capitalize(), table=table)
      
    @staticmethod
    def controller(name:str, model: str=None, resource: bool=False):
        render = ""
        if model:
            render += Template("controllers.model").render(model=model.lower(), Model=model.capitalize())
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
    def middleware(name: str, table: str):
        return Template("middleware").render(name=name, table=table)  
    
    # def env(**kwargs): 

    #     session_name = kwargs.get("session_name", f"{app_name}_session")
    #     session_driver = kwargs.get("session_driver", "file")
    #     session_lifetime = kwargs.get("session_lifetime", 30)
        
    #     code= env.app(app_name, app_lang, app_debug, app_key)
    #     code+= env.session(session_name, session_driver, session_lifetime) 
    #     code+= env.database(db_name, db_path, db_driver)
    #     return code
    
    
    # @staticmethod
    # def view(view=None):
    #     if view == 'app':
    #         return views.app()
    #     elif view == 'main':
    #         return views.main()
    #     elif view == 'dashboard':
    #         return views.dashboard()
    #     else:
    #         return views.default()
    
    # @staticmethod
    # def route(route=None):
    #     if route == 'main':
    #         return routes.main()
    #     else:
    #         return routes.default()
        
    class Env:
        @staticmethod
        def app(**kwargs):
            name = kwargs.get("name", "creator")
            key = kwargs.get("key", False)
            lang = kwargs.get("lang", "en")
            debug = kwargs.get("debug", False)
            return Template("env.app").render(name=name, key=key, lang=lang, debug=debug)

        @staticmethod
        def database(**kwargs):
            name = kwargs.get("name", "database")
            path = kwargs.get("path", "database")
            driver = kwargs.get("driver", "sqlite")

            render = Template("env.databases.database").render(path=path)
            if driver == "sqlite":
                render += Template("env.databases.sqlite").render(name=name, path=path)
            elif driver == "mysql":
                render += Template("env.databases.mysql").render(name=name, path=path, port="3306")
            elif driver == "postgresql":
                render += Template("env.databases.postgresql").render(name=name, path=path, port="5432")
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
        
        