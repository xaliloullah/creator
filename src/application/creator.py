class Creator:

    @classmethod
    def setup(cls):
        from config import app, database

        from src.console import Terminal  
        

        from src.core import String, List, Dict, Path, Data, File, Task, Date, View, Route, Lang, Hash, Crypt, Debug, Storage, Structure, Injector, Event, Collection, Translator, Http, Session, Response, Request, Middleware, Handle, Redirect
        
        from src.utils import Image, Audio, Speaker, Animation, Keyboard
        from src.builds import Build

        from src.application.configs import Settings, Version

        from src.validators import Validator
        

        cls.name = app.name
        cls.mode = app.mode
        cls.author = app.author
        cls.description = app.description
        cls.key = app.key 
        cls.database = database.driver
        cls.lang = Lang(app.lang)
        cls.settings = Settings() 
        cls.version = Version(cls.settings.get("version"))
        cls.python = cls.settings.get("python")
        cls.packages = cls.settings.get("packages", {})

        cls.terminal = Terminal

        if app.mode == 'desktop': 
            from src.interfaces import Interface
            cls.interface = Interface

        cls.injector = Injector 
        cls.path = Path
        cls.file = File
        cls.data = Data
        cls.task = Task
        cls.date = Date
        cls.hash = Hash
        cls.crypt = Crypt
        cls.list = List  
        cls.string = String  
        cls.dict = Dict  
        cls.build = Build  
        cls.debug = Debug 
        cls.storage = Storage 
        cls.collection = Collection 
        cls.translator = Translator 
        cls.speaker = Speaker
        cls.keyboard = Keyboard
        cls.image = Image
        cls.audio = Audio
        cls.http = Http 
        cls.view = View 
        cls.routes = Route  
        cls.structure = Structure
        cls.event = Event
        # cls.auth = Auth
        cls.request: Request
        cls.session: Session
        cls.validator: Validator
        cls.response:Response
        cls.middleware=Middleware
        cls.handle = Handle
        cls.redirect = Redirect 

    @classmethod
    def configure(cls, **kwargs):
        cls.setup()
        cls.retry = kwargs.get("retry", True)
        cls.running = kwargs.get("running", True)
        cls.main = kwargs.get("main", "main") 
        try:
            if not cls.key:
                raise  KeyError("key is not set")
            cls.python = cls.settings.get("python", None)
            cls.packages = cls.settings.get("packages", {}) 
            cls.handle.setup(cls.injector)
            cls.keyboard.init()
            
            # cls.injector.register('request', cls.request) 
        except Exception as e:    
            if cls.retry:
                cls.create()
                return cls.configure(retry=False)
            else:
                raise RuntimeError("Configuration failed and retry is False") from e

    @classmethod
    def start(cls): 
        try:   
            cls.running = True
            while cls.running: 
                cls.redirect.route(cls.main)   
        except Exception as e:
            cls.handle.exception(e) 

    @classmethod
    def stop(cls, code: int = 0): 
        cls.running = False
        raise SystemExit(code)


    @classmethod
    def create(cls): 
        cls.terminal.highlight(cls.build.creator())   
        cls.settings.create()
        use_venv = cls.terminal.input("Do you want to create a virtual environment ?", type="checkbox", value="yes")
        if use_venv:
            animation = cls.terminal.animation() 
            thread = cls.task.do(animation.loader, spinner="blocks").start()
            cls.settings.create_venv()  
            cls.settings.activate_venv()  
            animation.stop()
            thread.stop()
            cls.terminal.success(cls.lang.get("success.create", resource="virtual environment"))

        use_vscode = cls.terminal.input("Do you want to setup VSCode configs ?", type="checkbox", value="yes")
        if use_vscode:
            cls.settings.vscode()

        cls.terminal.info(cls.lang.get("info.install", resource="packages"))
        animation = cls.terminal.animation() 
        thread = cls.task.do(animation.loader, spinner="blocks", message=cls.lang.get("info.install", resource="packages")).start()
        cls.settings.install_packages() 
        animation.stop()
        thread.stop()
        lang = cls.terminal.input(cls.lang.get("info.options", resource=f"lang"), type="select", options=cls.lang.languages, value="en", inline=False) 
        cls.generate_lang(lang)

        try:
            key = cls.hash.generate_key()
        except Exception as e:
            key = None
            cls.terminal.error(f"Failed to generate key: {e}")
        
        name = cls.terminal.input("name", value="creator") 
        from config import database
        database = cls.terminal.input(cls.lang.get("info.options", resource=f"database"), type="select", options=database.supported, value="sqlite", inline=False) 
        mode = cls.terminal.input(cls.lang.get("info.options", resource=f"mode"), type="select", options=['console', 'desktop'], value="console", inline=False) 
        debug = cls.terminal.input("Activate debug app", type="checkbox", value="no") 
        env = cls.build.Env.app(name=name, lang=lang, key=key, mode=mode, debug=debug) + cls.build.Env.database(driver=database, name=name, path=cls.path.databases()) + cls.build.Env.session(name=f"{name}_session")
        for key, value in cls.data(env, format='env').get().items():
            cls.settings.env().set(key, value)  
        
        do_migrate = cls.terminal.input("Do you want to run migrations now ?", type="checkbox", value="no")
        if do_migrate:
            cls.terminal.info("Running database migrations...")
            from src.databases.migration import Migration
            Migration.migrate()
        starter_kit = cls.terminal.input("Do you want to install a starter kit ?", type="select", options=["none", "api", "auth"], value="none")
        if starter_kit != "none":
            cls.terminal.info(f"Installing starter kit: {starter_kit}...")
        cls.settings.make_architecture(all=True) 

    @classmethod
    def clean(cls):
        cls.file(".").clean() 
        
    @classmethod
    def generate_lang(cls, lang): 
        cls.terminal.info(cls.lang.get("info.create", resource=f"lang {lang}"))
        if lang in cls.settings.get("i18n.supported"):
            langs:list = cls.settings.get("i18n.available")
            if lang not in langs:
                animation = cls.terminal.animation() 
                thread = cls.task.do(animation.loader, spinner="blocks", message=cls.lang.get("info.create", resource=f"lang {lang}")).start()
                cls.lang.generate(lang)
                langs.append(lang)
                cls.settings.set("i18n.available", langs) 
                animation.stop()
                thread.stop()
                cls.terminal.success(cls.lang.get("success.create", resource=f"lang {lang}")) 
            else:
                cls.terminal.info(cls.lang.get("error.exist", resource=f"lang '{lang}'"))
        else:
            cls.terminal.error(cls.lang.get("error.invalid", data=f"lang '{lang}'"))