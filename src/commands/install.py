from src.commands import Command, Creator 
import traceback

class InstallCommand(Command):
    @classmethod
    def config(cls, subparsers):
        parser:Command = subparsers.add_parser('install', help="Install or update a package")
        parser.add_argument('package', nargs='+', help="Name of the package to install or update")
        parser.add_argument('-v','--version', help="Specify the version of the package")
        parser.add_argument('-u','--update', action="store_true", help="Update the package instead of installing")
        parser.add_argument('-f', '--force', action="store_true", help="Force reinstall")
        parser.add_argument('--user', action="store_true", help="Install for current user")
        parser.add_argument('--quiet', action="store_true", help="Suppress output")
        parser.add_argument('--extra-args', nargs='*', help="Extra pip args")
        parser.set_defaults(func=cls.handle)

    @staticmethod
    def handle(args):
        try: 
            installed = Creator.settings.get("required")
            exclude = ["package", "update"]
            kwargs = {k: v for k, v in vars(args).items() if k not in exclude}

            for package in args.package:
                Creator.terminal.info(Creator.lang.get("info.install", resource=f"package {package}")) 
                if args.update:
                    Creator.task.update(package, **kwargs) 
                else:
                    if package in installed:
                        Creator.terminal.warning(f"Package '{package}' is already installed")
                        continue
                    else:
                        Creator.task.install(package, **kwargs) 
        except Exception as e:
            Creator.terminal.error(e)
