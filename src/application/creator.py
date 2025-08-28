class Creator:

    @classmethod
    def setup(cls):
        from src.console import Terminal  
        from src.core import Path, Data, File, Task, Date, View ,Route, Lang, Hash, Crypt, String, Storage, Injector, Collection,  Translator, Speaker, Http, Session, Response, Request 
        # , Interface 
        from src.builds import Build
        from src.application.configs import Settings, Version

        from config import app

        from src.validators.validator import Validator  
        # from src.models.auth import Auth
        cls.name = app.name
        cls.mode = app.mode
        cls.author = app.author
        cls.description = app.description
        cls.key = app.key
        cls.debug = app.debug
        cls.lang = Lang(app.lang)
        cls.settings = Settings
        cls.version = Version(cls.settings.get("version", None))
        cls.python = cls.settings.get("python", None)
        cls.packages = cls.settings.get("packages", {})


        cls.injector = Injector()
        cls.terminal = Terminal
        cls.path = Path
        cls.file = File
        cls.data = Data
        cls.task = Task
        cls.date = Date
        cls.hash = Hash
        cls.crypt = Crypt
        cls.string = String  
        cls.build = Build  
        cls.storage = Storage 
        cls.collection = Collection 
        cls.translator = Translator 
        cls.speaker = Speaker
        cls.http = Http 
        cls.view = View 
        cls.routes = Route 
        cls.http = Http
        # cls.interface =Interface
        # cls.auth = Auth
        cls.request = Request
        cls.session = Session
        cls.validator = Validator

    @classmethod
    def configure(cls, **kwargs):
        try:
            cls.setup()
            cls.retry = kwargs.get("retry", True)
            cls.main = kwargs.get("main", "main")   
            cls.request = cls.request(session=cls.session(), validator=cls.validator()) 
            # cls.auth.config(request = cls.request)
            cls.injector.register(cls.request, cls.request)
            cls.injector.register(cls.session, cls.request.session)
            cls.name = cls.settings.get("name") 
            cls.version.set(cls.settings.get("version"))   
            if cls.key:
                if cls.key  == cls.settings.get("key"):
                    return cls
                else:
                    raise RuntimeError("Invalid key provided in the configuration.")
            else:
                cls.create()
        except KeyError as e:    
            if cls.retry:   
                cls.settings.create()
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
    def create(cls):
        cls.terminal.progress_bar(10, 100, 50)
        cls.terminal.highlight(cls.build.creator())   
        cls.terminal.progress(10, 100)
        cls.settings.vscode()   
        cls.terminal.info(cls.lang.get("info.install", resource="packages"))
        cls.settings.install_packages()
        cls.terminal.progress(10, 100, spinner="blocks")
        lang = cls.terminal.input(cls.lang.get("info.options", resource=f"lang"), type="select", options=cls.lang.languages, value="en", inline=False)
        cls.generate_lang(lang)
        cls.setup()
        key = cls.hash.make("creator")
        cls.settings.set("key", key) 
        database = cls.terminal.input(cls.lang.get("info.options", resource=f"database"), type="select", options=cls.settings.get("databases"), value="sqlite", inline=False) 
        debug = cls.terminal.input("Activate debug app", type="checkbox", value="no")
        env = cls.build.Env.app(name=cls.name, lang=lang, key=key, debug=debug)
        env +="\n"+ cls.build.Env.database(driver=database, name=cls.name, path=cls.path.databases())
        env +="\n"+cls.build.Env.session(name=f"{cls.name}_session", driver="file", lifetime=30) 
        cls.file('.env').save(env) 
        # do migrate ?
        # use starter kits ?
        cls.settings.make_architecture(all=True) 

    @classmethod
    def clean(cls): 
        cls.terminal.progress_bar(10, 100) 
        cls.terminal.highlight(cls.build.creator())  
        cls.file(".").clean() 
        
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
        else:
            cls.terminal.error(cls.lang.get("error.invalid", data=f"lang '{lang}'"))
    
    @classmethod
    def handle_exception(cls, e): 
        raise Exception(cls.terminal.error(f"{str(e)}"))
    
    @classmethod
    def url(cls, uri, **kwargs): 
        pass
    
    @classmethod
    def route(cls, name, **kwargs): 
        from routes.route import Route
        if cls.mode == "web":
            return Route.resolve(name)['uri']
        Route.dispatch(name, cls.injector, **kwargs) 

    @classmethod
    def form(cls, **kwargs):
        cls.request.update(kwargs)