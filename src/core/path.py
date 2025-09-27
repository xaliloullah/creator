import os 

class Path:
    def __init__(self, path, **kwargs):
        self.set(self.format(path, **kwargs))

    def __str__(self):
        return self.get()

    def __repr__(self):
        return f'Path("{self.path}")'
    
    def __fspath__(self): 
        return str(self.path)

    @staticmethod
    def format(path:str, **kwargs):
        prefix = kwargs.get("prefix")
        suffix = kwargs.get("suffix")
        lower = kwargs.get("lower", False)
        upper = kwargs.get("upper", False) 
        capitalize = kwargs.get("capitalize", False) 
        replace = kwargs.get("replace")
        safe = kwargs.get("safe", False)
        separator = kwargs.get("separator", "/")
        ensure_endwith = kwargs.get("ensure_endwith")
        

        if isinstance(path, Path):
            path = path.get()
        if prefix:
            if isinstance(prefix, Path):
                prefix = prefix.get()
            path = os.path.join(str(prefix), path)
        if suffix:
            path += str(suffix)
        if replace and isinstance(replace, (tuple, list)):
            old, new = replace
            path = path.replace(str(old), str(new))
        if safe:
            import re
            path = re.sub(r"[^a-zA-Z0-9/_\-]", "_", path)
        if lower:
            path = path.lower()
        elif upper:
            path = path.upper()
        elif capitalize:
            path = path.capitalize()
        path = str(path).rstrip("/\\")
        path = os.path.normpath(path).replace("\\", "/")
        if separator != "/":
            path = path.replace("/", separator)
        if ensure_endwith:
            if path and not path.endswith(ensure_endwith):
                path += ensure_endwith
        return path
    
    def set(self, path):
        self.path = path

    def get(self, index=None) -> str:  
        return str(self.path)

    def join(self, path, **kwargs):   
        if path:
            self.set(os.path.join(self.path, self.format(path, **kwargs)))
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
    
    def ensure_exists(self, folder=False):
        if not self.exists():
            self.make(folder)
        return self
    
    def is_file(self):
        return os.path.isfile(self.path)

    def is_dir(self):
        return os.path.isdir(self.path)

    def exists(self):
        return os.path.exists(self.path)

    def strip(self, path=None):
        return os.path.splitext(path or self.path)
    
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
        ext = self.strip()[1]
        if with_dot:
            return ext if ext else ''
        return ext[1:] if ext else ''

    def name(self):
        return self.strip(self.basename())[0] 
    
    def make(self, folder=False):  
        if folder:
            os.makedirs(self.path, exist_ok=True)
        else:
            dir, file = self.split() 
            if dir: 
                os.makedirs(dir, exist_ok=True)
            if file:
                open(self.path, "a").close()  
        return self
    
    def remove(self):
        return os.remove(self.path)
    
    def parts(self, separator="/"):
        return self.path.split(separator)
    
    @staticmethod
    def cd(path: str):
        return os.chdir(os.path.dirname(path))
    
    # shortcuts 
    @staticmethod
    def app(path=None, **kwargs):
        return Path("app").join(path, **kwargs)

    @staticmethod
    def config(path=None, **kwargs):
        return Path("config").join(path, **kwargs)

    @staticmethod
    def databases(path=None, sqlite=False, **kwargs):
        if sqlite: 
            kwargs["ensure_endwith"] = ".db"
        from config import database
        return Path(database.path).join(path, **kwargs)  

    @staticmethod
    def docs(path=None, **kwargs):
        return Path("docs").join(path, **kwargs)

    @staticmethod
    def lang(path=None, **kwargs):
        return Path("lang").join(path, **kwargs)

    @staticmethod
    def public(path=None, **kwargs):
        return Path("public").join(path, **kwargs)

    @staticmethod
    def resources(path=None, **kwargs):
        return Path("resources").join(path, **kwargs)
    
    @staticmethod
    def interfaces(path=None, **kwargs):
        return Path("interfaces").join(path, **kwargs)
    
    @staticmethod
    def cli(path=None, **kwargs):
        return Path.interfaces(path)
    
    @staticmethod
    def ui(path=None, **kwargs):
        return Path.interfaces(path)

    @staticmethod
    def routes(path=None, **kwargs):
        return Path("routes").join(path, **kwargs)

    @staticmethod
    def storage(path=None, **kwargs):
        return Path("storage").join(path, **kwargs)

    @staticmethod
    def utils(path=None, **kwargs):
        return Path("utils").join(path, **kwargs)

    @staticmethod
    def builds(path=None, **kwargs):
        return Path("builds").join(path, **kwargs)

    @staticmethod
    def src(path=None, **kwargs):
        return Path("src").join(path, **kwargs)

    @staticmethod
    def python(path=None, **kwargs):
        return Path("python").join(path, **kwargs)

    # Files shortcuts
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
    def controllers(path=None, **kwargs):
        kwargs["ensure_endwith"] = ".py"
        return Path.app("controllers").join(path, **kwargs)

    @staticmethod
    def models(path=None, **kwargs):
        kwargs["ensure_endwith"] = ".py"
        return Path.app("models").join(path, **kwargs)

    @staticmethod
    def middlewares(path=None, **kwargs):
        kwargs["ensure_endwith"] = ".py"
        return Path.app("middlewares").join(path, **kwargs)
    
    @staticmethod
    def events(path=None, **kwargs):
        kwargs["ensure_endwith"] = ".py"
        return Path.app("events").join(path, **kwargs)

    @staticmethod
    def commands(path=None, **kwargs):
        kwargs["ensure_endwith"] = ".py"
        return Path.app("commands").join(path, **kwargs)

    @staticmethod
    def migrations(path=None, **kwargs):
        kwargs["ensure_endwith"] = ".py"
        from config import database
        return Path.databases(database.migrations['name']).join(path, **kwargs)

    @staticmethod
    def seeders(path=None, **kwargs):
        kwargs["ensure_endwith"] = ".py"
        return Path.databases("seeders").join(path, **kwargs) 
    
    @staticmethod
    def tests(path=None, **kwargs):
        kwargs["ensure_endwith"] = ".py"
        return Path("tests").join(path, **kwargs) 

    @staticmethod
    def architecture():
        return Path.docs("ARCHITECTURE.md")

    @staticmethod
    def asset(path=None, **kwargs):
        return Path.public("assets").join(path, **kwargs)

    @staticmethod
    def views(path=None, **kwargs):
        kwargs["ensure_endwith"] = ".cre"
        kwargs["replace"] = (".", "/")
        from config import app 
        # if app.mode == 'web':
        #     if not path.endswith(".html"):
        #         path += ".html" 
        return Path.resources(f"views/{app.mode}").join(path, **kwargs)

    @staticmethod
    def backups(path=None, **kwargs):
        if path and not path.endswith(".zip"):
            path += ".zip" 
        return Path.storage("backups").join(path, **kwargs)

    @staticmethod
    def session(path=None, **kwargs):
        return Path.storage("sessions").join(path, **kwargs)

    @staticmethod
    def versions(path=None, **kwargs):
        return Path.storage("versions").join(path, **kwargs)

    @staticmethod
    def application(path=None, **kwargs):
        return Path.src("application").join(path, **kwargs)

    @staticmethod
    def environment(path="python", **kwargs):
        return Path.src("environment").join(path, **kwargs)

    @staticmethod
    def settings(path="creator.json", **kwargs):
        return Path(path, **kwargs) 
    
    @staticmethod
    def cache(path, **kwargs):
        return Path.app("cache").join(path, **kwargs)

    @staticmethod
    def logs():
        return Path.storage("logs")

    @staticmethod
    def template(path=None, **kwargs):
        if path:
            path = path.replace(".", "/")
            if not path.endswith(".template"):
                path += ".template"
        return Path.src(Path.builds("templates")).join(path, **kwargs) 

    @staticmethod
    def vscode(path="settings.json", **kwargs):
        return Path(".vscode").join(path, **kwargs)