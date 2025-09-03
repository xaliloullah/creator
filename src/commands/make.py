# coding python
from src.commands import Command, Creator
import traceback  

class MakeCommand(Command):
    
    @classmethod
    def config(cls, subparsers):
        # ex :
        # parser = subparsers.add_parser('make', help="Create something")
        # parser.add_argument('--name', help="Name of the thing to create")
        # parser.set_defaults(func=cls.handle)


        # 'make' command
        parser:Command = subparsers.add_parser('make', help="Create a model, controller, migration, view, cache, backup, or a command")

        model_parser = parser.add_argument_group("model")
        model_parser.add_argument('--model', help="Create a new model")
        model_parser.add_argument('-m', '--migrate', action='store_true', help="Create a migration for the model")
        model_parser.add_argument('--driver', help="Set the driver of the model", default='database', choices=['database', 'file'])

        controller_parser = parser.add_argument_group("controller")
        controller_parser.add_argument('--controller', help="Create a new controller")
        controller_parser.add_argument('-r', '--resource', action='store_true', help="Create a resource for the controller")

        parser.add_argument('--migration', help="Create a new migration file")
        parser.add_argument('--middleware', help="Create a new middleware")
        parser.add_argument('--service', help="Create a new service")
        parser.add_argument('--view', help="Create a new view")
        parser.add_argument('--command', help="Create a new command")
        parser.add_argument('--seeder', help="Create a new seeder")
        
        cache_parser = parser.add_argument_group("cache")
        cache_parser.add_argument('--cache', type=str, nargs='?', help="cache app") 
        
        backup_parser = parser.add_argument_group("backup")
        backup_parser.add_argument('--backup', action='store_true', help="Create a new Backup")
        backup_parser.add_argument('-s','--source', help="Specify the source location for the backup")
        backup_parser.add_argument('-d', '--destination', help="Specify the destination location for the backup")
        backup_parser.add_argument('-a','--all', action='store_true', help="Perform the backup action on all available sources and destinations")
        
        subparsers = parser.add_subparsers(dest='new command', help="Available commands of new", title="Sous-commandes pour 'new'")
        new_parser = subparsers.add_parser('new', help="Available commands")
        new_parser.add_argument("--project", type=str, nargs='?', help="Name of the new project to create")
        version_parser = new_parser.add_argument_group("version")
        version_parser.add_argument("-v", "--version", nargs='?', choices=['major', 'minor', 'patch'], const='patch')
        version_parser.add_argument('-s','--suffix', choices=['alpha', 'beta', 'rc','stable'],   help="suffix of the version")
 
        new_parser.set_defaults(func=cls.new)
        parser.set_defaults(func=cls.handle)

    @staticmethod
    def handle(args):
        """Create a new model, controller, migration or a backup."""
        if args.controller:
            name = Creator.string(args.controller).pascalcase()
            try: 
                filename = Creator.path.controllers(name.snakecase())
                if Creator.file(filename).exists():
                    return Creator.terminal.error(Creator.lang.get("error.exist", resource=f"Controller '{args.controller}'"))
                Creator.file(filename).ensure_exists().save(Creator.build.controller(Creator.file(name).name, args.model, args.resource))
                Creator.terminal.success(Creator.lang.get("success.create", resource=f"Controller '{args.controller}'"))
            except Exception:
                Creator.terminal.error(f"{traceback.format_exc()}")  

        elif args.model:
            name = Creator.string(args.model).pascalcase()
            table = name.pluralize().snakecase()
            try: 
                filename = Creator.path.models(name.snakecase())
                if Creator.file(filename).exists():
                    return Creator.terminal.error(Creator.lang.get("error.exist", resource=f"Model '{args.model}'"))
                Creator.file(filename).ensure_exists().save(Creator.build.model(Creator.file(name).name, table, args.driver))
                Creator.terminal.success(Creator.lang.get("success.create", resource=f"Model '{args.model}'")) 
                
                if args.migrate: 
                    from src.databases.migration import Migration
                    Migration(table).create()
            except Exception:
                Creator.terminal.error(f"{traceback.format_exc()}") 
                
        elif args.migration:
            from src.databases.migration import Migration
            name = Creator.string(args.migration).snakecase()
            Migration(name).create()

        elif args.middleware:
            name = Creator.string(args.middleware).pascalcase() 
            try: 
                filename = Creator.path.middlewares(name.snakecase())
                if Creator.file(filename).exists(): 
                    return Creator.terminal.error(Creator.lang.get("error.exist", resource=f"middleware '{args.middleware}'"))
                Creator.file(filename).ensure_exists().save(Creator.build.middleware(Creator.file(name).name))  
                 
                Creator.terminal.success(Creator.lang.get("success.create", resource=f"middleware '{args.middleware}'"))
            except Exception:
                Creator.terminal.error(f"{traceback.format_exc()}") 

        elif args.command:
            name = Creator.string(args.command).pascalcase() 
            try:
                filename = Creator.path.commands(name.snakecase())
                if Creator.file(filename).exists():
                    return Creator.terminal.error(Creator.lang.get("error.exist", resource=f"command '{args.command}'"))
                Creator.file(filename).ensure_exists().save(Creator.build.command(Creator.file(name).name)) 
                Creator.terminal.success(Creator.lang.get("success.create", resource=f"command '{args.command}'"))
            except Exception:
                Creator.terminal.error(f"{traceback.format_exc()}") 

        elif args.seeder:
            name = Creator.string(args.seeder).pascalcase() 
            try: 
                filename = Creator.path.seeds(name.snakecase())
                if Creator.file(filename).exists():
                    return Creator.terminal.error(Creator.lang.get("error.exist", resource=f"seed '{args.seeder}'"))
                Creator.file(filename).ensure_exists().save(Creator.build.seed(Creator.file(name).name)) 
                Creator.terminal.success(Creator.lang.get("success.create", resource=f"seed '{args.seeder}'"))
            except Exception:
                Creator.terminal.error(f"{traceback.format_exc()}") 

        elif args.cache: 
            pass
            # name = str(args.cache).lower().replace(" ", "_")
            # if name == 'config': 
            #     Creator.settings.cache(source = Creator.path.config, destination=Creator.file.set_extension(Creator.path.config,'py'), mode="import") 
            # elif name == 'routes':
            #     Creator.settings.cache(source = Creator.path.routes, destination=Creator.file.set_extension(Creator.path.routes,'py'), mode="import") 
            # Creator.terminal.success(Creator.lang.get("success.create", resource=f"Cache '{args.cache}'"))

            
        elif args.backup:
            try:  
                source = Creator.path(".").join(args.source).absolute() 
                
                destination = args.destination
                if not destination:
                    destination = f"backup_{Creator.date.now().strftime('%Y%m%d_%H%M%S')}" 
                destination = Creator.path.backups(destination)
                Creator.file(destination).ensure_exists()
                all = args.all
                ignore = ["backups", "__pycache__", "storage", "databases", "python", ".env", ".git", ".vscode"]
              
                if not all: 
                    ignore.append("src") 
                     
                Creator.file(source).save(destination, format="zip", ignore=ignore) 
                Creator.terminal.success(Creator.lang.get("success.create", resource=f"Backup '{destination}'"))  
            except Exception:
                Creator.terminal.error(f"{traceback.format_exc()}") 

        elif args.view:
            if args.resource: 
                resources = ['index', 'create', 'edit', 'view']
                for resource in resources:
                    path = Creator.path.views(f"{args.view}.{resource}") 
                    if Creator.file(path).exists():
                        return Creator.terminal.error(Creator.lang.get("error.exist", resource=f"view '{path}'"))
                    Creator.file(path).save(getattr(Creator.build.View, resource)(path.parent().name()))
                  
                    Creator.terminal.success(Creator.lang.get("success.create", resource=f"View '{path}'"))
            else:
                path = Creator.path.views(args.view)
                if Creator.file(path).exists():
                    return Creator.terminal.error(Creator.lang.get("error.exist", resource=f"view '{path}'"))
                Creator.file(path).save(Creator.build.View.default(path.name()), format="py")
                Creator.terminal.success(Creator.lang.get("success.create", resource=f"View '{path}'"))
        else:
            Creator.terminal.warning(Creator.lang.get("warning.options", resource=f"model, controller, migration, backup, or view"))
        

    @staticmethod
    def new(args):
        try:   
            if args.version:
                if args.version == 'major':
                    Creator.version.major()
                elif args.version == 'minor':
                    Creator.version.minor()
                elif args.version == 'patch':
                    Creator.version.patch()
                    
                if args.suffix:
                    Creator.version.suffix(args.suffix) 
                source = Creator.path("").absolute() 
                     
                Creator.settings.set("version", Creator.version.get())
                Creator.settings.save()

                destination = f"{Creator.name}_{Creator.version}" 
                destination = Creator.path.storage(f"versions/{destination}.zip")
                Creator.file(destination).ensure_exists()
                ignore = ["__pycache__", "python"]  
                
                only = ['app',  'config', 'lang', 'resources', 'routes', 'src', 'creator', 'main.py']
                        
                Creator.file(source).save(destination, format="zip", only=only, ignore=ignore)   

                Creator.terminal.success(f"New version : {Creator.version} saved at {destination}") 

            elif args.project:
                Creator.terminal.info(Creator.lang.get("info.create", resource=f"project {args.project}"))  
 

            else: 
                Creator.terminal.warning("Please specify either a version or ... .")
        except Exception:
            Creator.terminal.error(f"{traceback.format_exc()}")
 
