from src.commands import Command, Creator 
import traceback

class UninstallCommand(Command):
    @classmethod
    def config(cls, subparsers): 
        parser:Command  = subparsers.add_parser('uninstall', help="Uninstall a package")
        parser.add_argument('package', nargs='+', help="Name(s) of the package to uninstall")
        parser.set_defaults(func=cls.handle)

    @staticmethod
    def handle(args):
        try:
            installed = Creator.settings.get("required")
            for package in args.package:
                if package not in installed:
                    Creator.terminal.warning(f"Package '{package}' is not installed")
                    continue
                Creator.terminal.info(Creator.lang.get("info.uninstall", resource=f"package {package}"))
                Creator.task.uninstall(package)
        except Exception as e:
            Creator.terminal.error(e)
            
