from src.commands import Command

class SettingCommand(Command):
    @classmethod
    def config(cls, subparsers):
        parser:Command = subparsers.add_parser('SettingCommand', help="Command to 'SettingCommand' something")
        # parser.add_argument('name', help="Name of the command")
        # parser.add_argument('--option', help="An optional argument for the command")
        # Add more arguments as needed
        parser.set_defaults(func=cls.handle)

    @staticmethod
    def handle(args):
        # 
        # Handle the command logic here
        # 
        pass