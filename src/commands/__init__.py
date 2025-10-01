import argparse
from main import Creator

class Command(argparse.ArgumentParser):
    commands = []
    @classmethod
    def setup(cls):
        try:
            from app.provider import Provider
            cls.commands = Provider.commands
        except ImportError:
            raise ImportError("Commands module not found. Please ensure that the commands are properly defined and imported.")

    # @classmethod
    # def add(cls, *command):
    #     cls.commands.extend(command)

    @classmethod
    def config(cls, subparsers: argparse._SubParsersAction) -> None:
        raise NotImplementedError("Each command must implement 'config'.")

    @staticmethod
    def handle(args: argparse.Namespace):
        raise NotImplementedError("Each command must implement 'handle'.")
    
    @classmethod
    def listen(cls):  
        parser = cls(prog=f"{Creator.terminal.style(f"{Creator.name} v{Creator.version} :", Creator.terminal.color.cyan, Creator.terminal.font.bold)}", description=f"{Creator.terminal.style(f"CLI tool for managing creator.", Creator.terminal.color.cyan, Creator.terminal.font.bold)}")
        subparsers = parser.add_subparsers(dest='command', help="Available Commands")
        parser.add_argument("-v", "--version", action='version', version=f'{Creator.terminal.style(Creator.version, Creator.terminal.color.cyan, Creator.terminal.font.bold)}', help="Show the version of the creator tool.") #type:ignore
        parser.add_argument("--author", action="store_true", help="Show the author of the creator tool.") 
        parser.add_argument("--description", action="store_true", help="Show the description of the creator tool.") 
        parser.add_argument("--python", action="store_true", help="Show the programming language used in the creator tool.") 
        parser.add_argument("--packages", action="store_true", help="Show the packages used in the creator tool.")
        parser.add_argument("--key", action="store_true", help="Show the key used in the creator tool.") 
        parser.add_argument("--clean", action="store_true", help="Clean the creator tool.") 
        parser.add_argument("--reinstall", action="store_true", help="Reinstall the creator tool.")
        parser.add_argument("--uninstall", action="store_true", help="Uninstall the creator tool.")
        parser.add_argument("--update", action="store_true", help="Update the creator tool.")
        parser.add_argument("--refresh", action="store_true", help="Refresh the creator tool.")
        parser.add_argument("--run", "--start", action="store_true", help="Start or run the creator tool.")

        for command in cls.commands:
            command.config(subparsers)

        args = parser.parse_args() 
        if hasattr(args, 'func'):
            args.func(args) 

        elif args.author:
            Creator.terminal.highlight(Creator.author)

        elif args.description: 
            Creator.terminal.quote(Creator.description, Creator.author)

        elif args.python:
            Creator.terminal.info(f"Python : {Creator.python}")

        elif args.packages:
            Creator.terminal.info(Creator.packages)

        elif args.key:
            Creator.terminal.info(Creator.key) 

        elif args.clean:
            Creator.terminal.animation().progress() 
            Creator.terminal.highlight(Creator.build.creator())
            Creator.clean() 

        elif args.reinstall: 
            Creator.terminal.animation().progress() 
            Creator.terminal.highlight(Creator.build.creator())
            Creator.settings.install_packages()

        elif args.uninstall: 
            Creator.terminal.animation().progress() 
            Creator.terminal.highlight(Creator.build.creator())  
            Creator.settings.uninstall_packages()

        elif args.update: 
            Creator.terminal.animation().progress() 
            Creator.terminal.highlight(Creator.build.creator())  
            Creator.settings.update()

        elif args.refresh: 
            Creator.terminal.animation().progress() 
            Creator.terminal.highlight(Creator.build.creator())  
            Creator.settings.make_architecture(all=True)

        elif args.run:
            Creator.start()  
        else:
            parser.print_help()