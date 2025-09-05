class Creator:

    @classmethod
    def setup(cls):
        from src.console import Terminal  
        from src.core import Path, Data, File, Task, Date, View ,Route, Lang, Hash, Crypt, String, Dict, Debug, Storage, Injector, Collection,  Translator, Speaker, Http, Session, Response, Request 
        # , Interface 
        from src.builds import Build
        from src.application.configs import Settings, Version
        from src.validators.validator import Validator  
        # from src.models.auth import Auth

        from config import app, database

        cls.name = app.name
        cls.mode = app.mode
        cls.author = app.author
        cls.description = app.description
        cls.key = app.key 
        cls.database = database.driver
        cls.lang = Lang(app.lang)
        cls.settings = Settings()
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
        cls.dict = Dict  
        cls.debug = Debug 
        cls.storage = Storage 
        cls.collection = Collection 
        cls.translator = Translator 
        cls.speaker = Speaker
        cls.http = Http 
        cls.view = View 
        cls.routes = Route  
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
            cls.debug.printer = cls.terminal.debug
            # cls.name = app.name
            # cls.mode = app.mode
            # cls.author = app.author
            # cls.description = app.description
            # cls.key = app.key 
            # cls.database = database.driver
            # cls.lang = Lang(app.lang)
            # cls.settings = Settings.first()
            # cls.version = Version(cls.settings.get("version", None))
            cls.python = cls.settings.get("python", None)
            cls.packages = cls.settings.get("packages", {})
            cls.request = cls.request(session=cls.session(), validator=cls.validator()) 
            # cls.auth.config(request = cls.request) 
            cls.injector.register('request', cls.request)
            cls.injector.register('session', cls.request.session) 
            cls.version.set(cls.settings.get("version"))   
            if cls.key:
                if cls.key == cls.settings.get("key"):
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
                raise RuntimeError("") from e

    @classmethod 
    def stop(cls): 
        exit(1)

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
        use_venv = cls.terminal.input("Do you want to create a virtual environment ?", type="checkbox", value="yes")
        if use_venv:
            cls.settings.create_venv()  
            cls.terminal.success("Virtual environment created.")
            cls.settings.activate_venv() 
        else:
            cls.terminal.info("Skipping virtual environment setup.")

        use_vscode = cls.terminal.input("Do you want to setup VSCode configs ?", type="checkbox", value="yes")
        if use_vscode:
            cls.settings.vscode()

        cls.terminal.progress(5, 100, spinner="dots")
        cls.terminal.info(cls.lang.get("info.install", resource="packages"))
        cls.settings.install_packages()
        cls.terminal.progress(2, 100, spinner="blocks")
        lang = cls.terminal.input(cls.lang.get("info.options", resource=f"lang"), type="select", options=cls.lang.languages, value="en", inline=False)
        cls.generate_lang(lang) 
        try:
            key = cls.hash.make("creator")
            cls.settings.set("key", key) 
        except:
            key = cls.settings.get("key")
        
        name = cls.terminal.input("name", value="creator") 
        database = cls.terminal.input(cls.lang.get("info.options", resource=f"database"), type="select", options=cls.settings.get("databases"), value="sqlite", inline=False) 
        mode = cls.terminal.input(cls.lang.get("info.options", resource=f"mode"), type="select", options=['console', 'web', 'desktop'], value="console", inline=False) 
        debug = cls.terminal.input("Activate debug app", type="checkbox", value="no")
        env = cls.build.Env.app(name=name, lang=lang, key=key, mode=mode, debug=debug)
        env +="\n"+ cls.build.Env.database(driver=database, name=name, path=cls.path.databases())
        env +="\n"+cls.build.Env.session(name=f"{name}_session") 
        cls.file('.env').save(env) 
        do_migrate = cls.terminal.input("Do you want to run migrations now ?", type="checkbox", value="no")
        if do_migrate:
            cls.terminal.info("Running database migrations...")
        starter_kit = cls.terminal.input("Do you want to install a starter kit ?", type="select", options=["none", "api", "web", "auth"], value="none")
        if starter_kit != "none":
            cls.terminal.info(f"Installing starter kit: {starter_kit}...")
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
                cls.lang.setup(lang)
                cls.terminal.success(cls.lang.get("success.create", resource=f"lang {lang}")) 
        else:
            cls.terminal.error(cls.lang.get("error.invalid", data=f"lang '{lang}'"))
    
    @classmethod
    def handle_exception(cls, e): 
        raise Exception(cls.terminal.error(f"{str(e)}"))
    
    @classmethod
    def url(cls, uri, **kwargs): 
        return uri
    
    @classmethod
    def route(cls, name, intended=None, **kwargs): 
        from routes.route import Route 
        Route.dispatch(name, **kwargs) 

    @classmethod
    def form(cls, **kwargs):
        cls.request.update(kwargs)