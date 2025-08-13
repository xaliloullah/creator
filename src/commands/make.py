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

        parser.add_argument('--model', help="Create a new model")
        parser.add_argument('--controller', help="Create a new controller")
        parser.add_argument('--migration', help="Create a new migration file")
        parser.add_argument('--middleware', help="Create a new middleware")
        parser.add_argument('--service', help="Create a new service")
        parser.add_argument('--view', help="Create a new view")
        parser.add_argument('--command', help="Create a new CREATOR command")
        parser.add_argument('--seeder', help="Create a new CREATOR seeder")
        parser.add_argument('-m', '--migrate', action='store_true', help="Create a migration for the model")
        parser.add_argument('-r', '--resource', action='store_true', help="Create a resource for the controller")
        
        make_cache_parser = parser.add_argument_group("cache")
        make_cache_parser.add_argument('--cache', type=str, nargs='?', help="cache app") 
        
        make_backup_parser = parser.add_argument_group("backup")
        make_backup_parser.add_argument('--backup', action='store_true', help="Create a new Backup")
        make_backup_parser.add_argument('-s','--source', help="Specify the source location for the backup")
        make_backup_parser.add_argument('-d','--destination', help="Specify the destination location for the backup")
        make_backup_parser.add_argument('-a','--all', action='store_true', help="Perform the backup action on all available sources and destinations")
        
        make_subparsers = parser.add_subparsers(dest='new command', help="Available commands of new", title="Sous-commandes pour 'new'")
        make_new_parser = make_subparsers.add_parser('new', help="Available commands")
        make_new_parser.add_argument("--project", type=str, nargs='?', help="Name of the new project to create")
        make_version_parser = make_new_parser.add_argument_group("version")
        make_version_parser.add_argument("-v", "--version", nargs='?',choices=['major', 'minor', 'patch'], const='patch')
        make_version_parser.add_argument('-s','--suffix', choices=['alpha', 'beta', 'rc','stable'],   help="suffix of the version")

        # new_parser = parser.add_subparsers('new', action='store_true', help="Perform the backup action on all available sources and destinations")
        make_new_parser.set_defaults(func=cls.new)
        parser.set_defaults(func=cls.handle)

    @staticmethod
    def handle(args):
        """Create a new model, controller, migration or a backup."""
        if args.controller:
            name = str(args.controller).replace(" ", "_") 
            try: 
                filename = Creator.path.controllers(name)
                if Creator.file(filename).exists():
                    return Creator.terminal.error(Creator.lang.get("error.exist", resource=f"Controller '{args.controller}'"))
                Creator.file(filename).ensure_exists().save(Creator.build.controller(Creator.file(filename).name, args.model, args.resource))
                Creator.terminal.success(Creator.lang.get("success.create", resource=f"Controller '{args.controller}'"))
            except Exception:
                Creator.terminal.error(f"{traceback.format_exc()}")  

        elif args.model:
            name = str(args.model).replace(" ", "_")
            table = name.lower()
            if not table.endswith('s'):
                table += 's'
            try:
                path = "app/models/"
                filename = path + name.lower() + ".py"
                if Creator.file(filename).exists():
                    return Creator.terminal.error(Creator.lang.get("error.exist", resource=f"Model '{args.model}'"))
                Creator.file(filename).ensure_exists().save(Creator.build.model(Creator.file(name).name, table))
                Creator.terminal.success(Creator.lang.get("success.create", resource=f"Model '{args.model}'")) 
                
                if args.migrate: 
                    from src.databases.migration import Migration
                    Migration(table).create()
            except Exception:
                Creator.terminal.error(f"{traceback.format_exc()}") 
                
        elif args.migration:
            from src.databases.migration import Migration
            name = str(args.migration).lower().replace(" ", "_")
            Migration(name).create()

        elif args.middleware:
            name = str(args.middleware).replace(" ", "_") 
            try:
                path = "app/middlewares/"
                filename = path + name + ".py"
                if Creator.file(filename).exists(): 
                    return Creator.terminal.error(Creator.lang.get("error.exist", resource=f"middleware '{args.middleware}'"))
                Creator.file(filename).ensure_exists().save(Creator.build.middleware(Creator.file(name).name, args.model))  
                 
                Creator.terminal.success(Creator.lang.get("success.create", resource=f"middleware '{args.middleware}'"))
            except Exception:
                Creator.terminal.error(f"{traceback.format_exc()}") 

        elif args.command:
            name = str(args.command).replace(" ", "_") 
            try:
                filename = Creator.path.commands(name)
                if Creator.file(filename).exists():
                    return Creator.terminal.error(Creator.lang.get("error.exist", resource=f"command '{args.command}'"))
                Creator.file(filename).ensure_exists().save(Creator.build.command(Creator.file(name).name)) 
                Creator.terminal.success(Creator.lang.get("success.create", resource=f"command '{args.command}'"))
            except Exception:
                Creator.terminal.error(f"{traceback.format_exc()}") 

        elif args.seeder:
            name = str(args.seeder).replace(" ", "_") 
            try: 
                filename = Creator.path.seeds(name)
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
                    timestamp = Creator.date.now().strftime('%Y%m%d_%H%M%S') 
                    destination = f"backup_{timestamp}" 
                destination = Creator.path.storage(f"backups/{destination}.zip")
                Creator.file(destination).ensure_exists()
                all = args.all
                ignore = ["backups", "__pycache__"]
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
                    Creator.file(path).save(getattr(Creator.build.View, resource)(args.view))
                  
                    Creator.terminal.success(Creator.lang.get("success.create", resource=f"View '{path}'"))
            else:
                path = Creator.path.views(args.view)
                Creator.file(path).save(Creator.build.View.default(args.view), format="py")
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
                Creator.update()
                source = Creator.path("").absolute() 
                     
                destination = f"{Creator.name}_{Creator.version}" 
                destination = Creator.path.storage(f"versions/{destination}.zip")
                Creator.file(destination).ensure_exists()
                ignore = ["__pycache__"]  
                
                only = ['app', 'src', 'config', 'resources', 'routes', 'lang', 'creator', 'main.py']
                        
                Creator.file(source).save(destination, format="zip", only=only, ignore=ignore)   
                Creator.terminal.success(f"New version : {Creator.version} saved at {destination}") 

            elif args.project:
                Creator.terminal.info(Creator.lang.get("info.create", resource=f"project {args.project}"))  
 

            else: 
                Creator.terminal.warning("Please specify either a version or ... .")
        except Exception:
            Creator.terminal.error(f"{traceback.format_exc()}")
 
