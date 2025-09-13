from src.commands import Command
from main import Creator
class RouteCommand(Command):
    @classmethod
    def config(cls, subparsers):
        parser:Command = subparsers.add_parser('route', help="Command to 'Route' something") 
        parser.add_argument('--list', action="store_true", help="An optional argument for the command") 
        parser.set_defaults(func=cls.handle)

    @staticmethod
    def handle(args):
        if args.list:
            for route in Creator.routes.list().items():
                Creator.terminal.list(route, display=True)
