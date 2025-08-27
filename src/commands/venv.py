from src.commands import Command, Creator 
import traceback

class VenvCommand(Command):
    @classmethod
    def config(cls, subparsers):  
        parser: Command = subparsers.add_parser("venv", help="Manage a virtual environment")
        parser.add_argument("--create", help="Create a virtual environment", action="store_true")
        parser.add_argument("--path", help="Specify the path of the virtual environment")
        parser.add_argument("--activate", help="Activate the virtual environment", action="store_true")
        parser.add_argument("--deactivate", help="Deactivate the virtual environment", action="store_true")
        parser.add_argument("--remove", help="Remove the virtual environment", action="store_true")
        parser.set_defaults(func=cls.handle)

    @staticmethod
    def handle(args):
        if args.create:
            Creator.terminal.info(Creator.lang.get("info.create", resource="virtual environment"))
            Creator.settings.create_venv()
        elif args.activate:
            Creator.terminal.info(Creator.lang.get("info.run", resource="virtual environment"))
            Creator.settings.activate_venv(args.path)
        elif args.deactivate:
            Creator.terminal.info(Creator.lang.get("info.run", resource="virtual environment"))
            Creator.settings.deactivate_venv(args.path)
        else:
            Creator.terminal.warning(Creator.lang.get("warning.options", resource="create, activate, or deactivate"))
                
            
