from src.console import Terminal  
from src.core import Path, File, Data, Task, Date, View, Lang, Route, Hash, Crypt, Injector, Storage, Collection, Translator, Http
#

# , Interface 
from src.builds import Build
from src.application.configs import Settings, Version

 
from config import app

class Creator:
    
    settings = Settings
    version = Version(settings.get("version", None))
    python = settings.get("python", None)
    packages = settings.get("packages", {})

    name = app.name
    author = app.author
    description = app.description
    lang = Lang(app.lang)
    key = app.key
    debug = app.debug

    injector = Injector()
    terminal = Terminal
    path = Path
    file = File
    data = Data
    task = Task
    date = Date
    crypt = Crypt
    hash = Hash
    build = Build  
    storage = Storage 
    collection = Collection 
    translator = Translator 
    http = Http 
    view = View 
    routes = Route 
    # http = Http
    # interface =Interface
        
    @classmethod
    def configure(cls, **kwargs):
        try:
            retry = kwargs.get("retry", True)
            cls.main = kwargs.get("main", "main") 
            from src.application.contexts import Session, Request 
            from src.validators.validator import Validator

            cls.request = Request(session = Session(), validator = Validator()) 
            cls.injector.register(Request, cls.request)
            cls.injector.register(Session, cls.request.session)

            cls.name = cls.settings.get("name") 
            cls.version = Version(cls.settings.get("version"))   
            if cls.key:
                if cls.key  == cls.settings.get("key"):
                    return cls
                else:
                    raise RuntimeError("Invalid key provided in the configuration.")
            else:
                cls.setup()
        except KeyError as e:    
            if retry:   
                cls.settings.setup()
                return cls.configure(retry=False)
            else:
                raise RuntimeError("Configuration échouée après une tentative de récupération.") from e

    @classmethod 
    def run(cls, **kwargs): 
        try:   
            cls.route(cls.main)  
             
        except Exception as e:
            cls.handle_exception(e) 

    @classmethod
    def setup(cls):
        cls.terminal.progress_bar(10, 100, 50)
        cls.terminal.highlight(cls.build.creator())   
        cls.terminal.progress(10, 100)
        cls.settings.vscode()   
        cls.terminal.info(cls.lang.get("info.install", resource="packages"))
        cls.settings.install_packages()
        cls.terminal.progress(1, 100)
        lang = cls.terminal.input(cls.lang.get("info.options", resource=f"lang"), type="select", options=cls.lang.languages, value="en")
        cls.generate_lang(lang)
        key = cls.hash.make("creator")
        cls.settings.set("key", key)
        database = cls.terminal.input(cls.lang.get("info.options", resource=f"database"), type="select", options=cls.settings.get("supported_database"), value="sqlite") 
        debug = cls.terminal.input("Activate debug app", type="checkbox", value="no")
        env = Build.Env.app(name=cls.name, lang=lang, key=key, debug=debug)
        env +="\n"+ Build.Env.database(driver=database, name=cls.name, path=cls.path.databases(cls.name))
        env +="\n"+Build.Env.session(name=f"{cls.name}_session", driver="file", lifetime=30) 
        cls.file('.env').save(env) 
        cls.settings.make_architecture(all=True) 

    @classmethod
    def update(cls): 
        cls.terminal.progress_bar(10, 100) 
        cls.terminal.highlight(cls.build.creator())  
        cls.settings.update()

    @classmethod
    def generate_lang(cls, lang):
        if lang in cls.lang.languages:
            langs:list = cls.settings.get("langs")
            if lang not in langs:
                cls.terminal.info(cls.lang.get("info.create", resource=f"lang {lang}"))
                cls.lang.generate(lang)
                langs.append(lang)
                cls.settings.set("langs", langs)
                cls.terminal.success(cls.lang.get("success.create", resource=f"lang {lang}"))
                cls.settings.update()
        else:
            cls.terminal.error(cls.lang.get("error.invalid", data=f"lang '{lang}'"))
    
    @classmethod
    def handle_exception(cls, e): 
        raise Exception(cls.terminal.error(f"{str(e)}"))
    
    @classmethod
    def route(cls, name, **kwargs): 
        from routes.route import Route
        Route.dispatch(name, cls.injector,**kwargs) 