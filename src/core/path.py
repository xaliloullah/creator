import os

class Path:
    def __init__(self, path:str):
        self.set(path)

    def __str__(self):
        return self.path

    def __repr__(self):
        return f'Path("{self.path}")'
    
    def __fspath__(self): 
        return str(self.path)
    
    def set(self, path:str, **kwargs):
        self.path = path.rstrip("/\\").replace("\\","/") if isinstance(path, str) else path

    def get(self) -> str: 
        return str(self.path)

    def join(self, *paths):  
        path = [path for path in paths if path is not None]
        self.set(os.path.join(self.path, *path))
        return self

    def absolute(self):
        self.set(os.path.abspath(self.path))
        return self
    
    def current(self): 
        self.set(os.path.join(os.getcwd(), self.path))
        return self
    
    def relative(self, start=os.getcwd()):
        self.set(os.path.relpath(self.path, start))
        return self
    
    def resolve(self):
        self.set(os.path.realpath(self.path))
        return self
    
    def ensure_exists(self):
        if not self.exists():
            self.make()
        return self
    
    def is_file(self):
        return os.path.isfile(self.path)

    def is_dir(self):
        return os.path.isdir(self.path)

    def exists(self):
        return os.path.exists(self.path)

    def strip(self):
        return os.path.splitext(self.path)
    
    def split(self):
        return os.path.split(self.path)

    def basename(self):
        return os.path.basename(self.path)

    def rename(self, name): 
        path = os.path.join(self.parent(), name)
        os.rename(self.path, path)
        self.set(path)
        return self
    
    def parent(self):
        return Path(os.path.dirname(self.path))
    
    def extension(self, **kwargs):
        with_dot = kwargs.get("with_dot", False)
        ext = os.path.splitext(self.path)[1]
        if with_dot:
            return ext if ext else ''
        return ext[1:] if ext else ''

    def name(self):
        return os.path.splitext(self.basename())[0] 
    
    def make(self): 
        if self.is_file():
            dir, file = self.split() 
            if dir:
                os.makedirs(dir, exist_ok=True)
            if file:
                open(self.path, "a").close() 
        else :
            os.makedirs(self.path, exist_ok=True)
        return self
    
    def remove(self):
        return os.remove(self.path)
    
    def parts(self):
        return self.path.split("/")
    
    @staticmethod
    def cd(path: str):
        return os.chdir(os.path.dirname(path))
    
    # Domain-specific shortcuts (factory methods)
    @staticmethod
    def app(path=None):
        return Path("app").join(path)

    @staticmethod
    def config(path=None):
        return Path("config").join(path)

    @staticmethod
    def databases(path:str=None, sqlite=False):
        if sqlite and not path.endswith(".db"):
            path += ".db"
        return Path("databases").join(path)  

    @staticmethod
    def docs(path=None):
        return Path("docs").join(path)

    @staticmethod
    def lang(path=None):
        return Path("lang").join(path)

    @staticmethod
    def public(path=None):
        return Path("public").join(path)

    @staticmethod
    def resources(path=None):
        return Path("resources").join(path)
    @staticmethod
    def interfaces(path=None):
        return Path("interfaces").join(path)
    
    @staticmethod
    def cli(path=None):
        return Path.interfaces(path)
    
    @staticmethod
    def ui(path=None):
        return Path.interfaces(path)

    @staticmethod
    def routes(path=None):
        return Path("routes").join(path)

    @staticmethod
    def storage(path=None):
        return Path("storage").join(path)

    @staticmethod
    def utils(path=None):
        return Path("utils").join(path)

    @staticmethod
    def builds(path=None):
        return Path("builds").join(path)

    @staticmethod
    def src(path=None):
        return Path("src").join(path)

    @staticmethod
    def python(path=None):
        return Path("python").join(path)

    # Files
    @staticmethod
    def env():
        return Path(".env")

    @staticmethod
    def requirements():
        return Path("requirements.json")

    @staticmethod
    def gitignore():
        return Path(".gitignore")

    @staticmethod
    def readme():
        return Path("README.md")

    @staticmethod
    def license():
        return Path("LICENSE")

    # Nested
    @staticmethod
    def controllers(path:str=None):
        if path and not path.endswith(".py"):
            path += ".py"
        return Path.app("controllers").join(path)

    @staticmethod
    def models(path:str=None):
        if path and not path.endswith(".py"):
            path += ".py" 
        return Path.app("models").join(path)

    @staticmethod
    def middlewares(path:str=None):
        if path and not path.endswith(".py"):
            path += ".py"
        return Path.app("middlewares").join(path)

    @staticmethod
    def commands(path=None):
        if path and not path.endswith(".py"):
            path += ".py"
        return Path.app("commands").join(path)

    @staticmethod
    def migrations(path=None):
        if path and not path.endswith(".py"):
            path += ".py"
        return Path.databases("migrations").join(path)

    @staticmethod
    def seeds(path=None):
        if path and not path.endswith(".py"):
            path += ".py"
        return Path.databases("seeds").join(path) 

    @staticmethod
    def architecture():
        return Path.docs("ARCHITECTURE.md")

    @staticmethod
    def assets(path=None):
        return Path.public("assets").join(path)

    @staticmethod
    def views(path:str=None):
        if path:
            path = path.replace(".", "/")
            if not path.endswith(".cre"):
                path += ".cre" 
        return Path.resources("views").join(path)

    @staticmethod
    def backups(path=None):
        return Path.storage("backups").join(path)

    @staticmethod
    def sessions(path=None):
        return Path.storage("sessions").join(path)

    @staticmethod
    def versions(path=None):
        return Path.storage("versions").join(path)

    @staticmethod
    def creator(path=None):
        return Path.src("application").join(path)

    @staticmethod
    def environment(path="python"):
        return Path.src("environment").join(path)

    @staticmethod
    def settings(path="settings.json"):
        return Path.creator("configs").join(path)

    @staticmethod
    def cache(path):
        return Path.app("cache").join(path)

    @staticmethod
    def logs():
        return Path.src(Path.app(), "logs")

    @staticmethod
    def template(path:str=None):
        if path:
            path = path.replace(".", "/")
            if not path.endswith(".template"):
                path += ".template"
        return Path.src(Path.builds("templates")).join(path)

    @staticmethod
    def vscode(path="settings.json"):
        return Path(".vscode").join(path)