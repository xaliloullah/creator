from src.commands import Command, Creator 
import traceback

class DeleteCommand(Command):
    @classmethod
    def config(cls, subparsers): 

        # 'delete' command
        parser:Command  = subparsers.add_parser('delete', help="Delete a model, controller, migration, view, cache, backup, or a command")
        parser.add_argument('--model', help="Delete a model")
        parser.add_argument('--controller', help="Delete a controller")
        parser.add_argument('--migration', help="Delete a migration file")
        parser.add_argument('--middleware', help="Delete a middleware")
        parser.add_argument('--command', help="Delete a command")
        parser.add_argument('--view', help="Delete a view")
        parser.add_argument('--seeder', help="Delete a seeder")
        parser.add_argument('--test', help="Delete a test")
        parser.add_argument('-r', '--resource', action='store_true', help="Create a resource for the controller")
        parser.add_argument('--backup', help="Delete a backup")
        parser.set_defaults(func=cls.handle)

    @staticmethod
    def handle(args):
        """Delete a model, controller, migration, or a backup."""
        if args.controller:
            name = Creator.string(args.controller).pascalcase()
            filename = Creator.path.controllers(name.snakecase())
            if Creator.file(filename).exists():
                Creator.file(filename).delete() 
                Creator.terminal.success(Creator.lang.get("success.delete", resource=f"Controller '{args.controller}'"))
            else:
                Creator.terminal.error(Creator.lang.get("error.delete", resource=f"Controller '{args.controller}'")) 
        elif args.model:
            name = Creator.string(args.model).pascalcase() 
            filename = Creator.path.models(name.snakecase()) 
            if Creator.file(filename).exists():
                Creator.file(filename).delete() 
                Creator.terminal.success(Creator.lang.get("success.delete", resource=f"Model '{args.model}'"))
            else:
                Creator.terminal.error(Creator.lang.get("error.delete", resource=f"Model {args.model}"))      
        elif args.migration: 
            name = Creator.string(args.migration).snakecase()
            filename = Creator.path.migrations(name)
            if Creator.file(filename).exists():
                Creator.file(filename).delete()
                Creator.terminal.success(Creator.lang.get("success.delete", resource=f"Migration '{args.migration}'")) 
            else:
                Creator.terminal.error(Creator.lang.get("error.delete", resource=f"Migration '{args.migration}'")) 

        elif args.backup:
            try:  
                name = str(args.backup)
                folder = Creator.path.backups(name)
                if Creator.file(folder).exists():
                    Creator.file(folder).delete()
                    Creator.terminal.success(Creator.lang.get("success.delete", resource=f"Backups {args.backup}"))
                else:
                    Creator.terminal.error(Creator.lang.get("error.delete",resource=f"Backups {args.backup}")) 
            except Exception as e:
                Creator.terminal.error(f"{traceback.format_exc()}")

        elif args.middleware: 
            name = str(args.middleware).replace(" ", "_")
            filename = Creator.path.middlewares(name)
            if Creator.file(filename).exists():
                Creator.file(filename).delete() 
                Creator.terminal.success(Creator.lang.get("success.delete", resource=f"Middleware '{args.middleware}'"))
            else:
                Creator.terminal.error(Creator.lang.get("error.delete", resource=f"Middleware '{args.middleware}'")) 
        
        elif args.command: 
            name = Creator.string(args.command).pascalcase() 
            filename = Creator.path.commands(name.snakecase())  
            if Creator.file(filename).exists():
                Creator.file(filename).delete() 
                Creator.terminal.success(Creator.lang.get("success.delete", resource=f"command '{args.command}'"))
            else:
                Creator.terminal.error(Creator.lang.get("error.delete", resource=f"command '{args.command}'")) 


        elif args.view:
            if args.resource: 
                resources = ['index', 'create', 'edit', 'view']
                for resource in resources:
                    path = Creator.path.views(f"{args.view}.{resource}") 
                    if Creator.file(path).exists():
                        Creator.file(path).delete()
                        Creator.terminal.success(Creator.lang.get("success.delete", resource=f"View '{path}'")) 
                    else:
                        Creator.terminal.error(Creator.lang.get("error.delete", resource=f"View '{path}'"))  
            else:
                path = Creator.path.views(args.view)
                if Creator.file(path).exists(): 
                    Creator.file(path).delete()
                    Creator.terminal.success(Creator.lang.get("success.delete", resource=f"View '{path}'"))
                else:
                    Creator.terminal.error(Creator.lang.get("error.delete", resource=f"View '{args.view}'"))  

        elif args.seeder: 
            name = Creator.string(args.seeder).pascalcase() 
            filename = Creator.path.seeds(name.snakecase())   
            if Creator.file(filename).exists():
                Creator.file(filename).delete() 
                Creator.terminal.success(Creator.lang.get("success.delete", resource=f"seeder '{args.seeder}'"))
            else:
                Creator.terminal.error(Creator.lang.get("error.delete", resource=f"seeder '{args.seeder}'")) 

        elif args.test: 
            name = Creator.string(args.test).pascalcase() 
            filename = Creator.path.tests(name.snakecase())   
            if Creator.file(filename).exists():
                Creator.file(filename).delete() 
                Creator.terminal.success(Creator.lang.get("success.delete", resource=f"test '{args.test}'"))
            else:
                Creator.terminal.error(Creator.lang.get("error.delete", resource=f"test '{args.test}'")) 
 
        else:
            Creator.terminal.warning(Creator.lang.get("warning.options", resource=f"model, controller, migration, backup, or view"))
            