from src.commands import Command, Creator 
import traceback

class PublishCommand(Command):
    @classmethod
    def config(cls, subparsers):  
        parser:Command = subparsers.add_parser('publish', help="Publish a resources")
        parser.add_argument('--packages', help="Name of the package to publish",  choices=['requirements', 'lang', 'env'])
        parser.add_argument('-f', '--format', help="Name of the lang to publish", choices=['txt', 'json', 'env'], default='json')
        parser.add_argument('--tag', help="tag of the package to publish")  
        parser.set_defaults(func=cls.handle)

    @staticmethod
    def handle(args):
        if args.packages == 'requirements':
            requirements = Creator.file(Creator.path.settings()).load(format="json")
            Creator.file((args.tag or args.packages)+'.'+args.format).save(requirements["packages"], format=args.format)