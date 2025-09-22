from src.commands import Command, Creator

class SeedCommand(Command):
    @classmethod
    def config(cls, subparsers):
        parser:Command = subparsers.add_parser('seed', help="Command to 'seed' something")
        parser_group = parser.add_argument_group("seed")
        parser_group.add_argument('--run', action='store_true', help="Run the Seeders")  
        parser_group.add_argument('name', nargs='?', help="Name the Seeders")  
        parser_group.add_argument('--list', action='store_true', help="List all Seeders") 
        parser.set_defaults(func=cls.handle)

    @staticmethod
    def handle(args):
        from src.databases.seeder import Seeder 
        if not any([
            args.run, 
            args.list
        ]):
            args.run = True
        """Execute Seeder actions.""" 
        
        if args.run:
            Creator.terminal.info(Creator.lang.get("info.run", resource="Seeder")) 
            if args.name:
                Seeder.run(args.name)
            else:
                Seeder.seed()  

        elif args.list:
            Creator.terminal.info(Creator.lang.get("info.list", resource="Seeder"))
            Seeders = Seeder.get()
            Creator.terminal.list(Seeders, icon = Creator.terminal.icon.arrow_right(), margin=3, color = Creator.terminal.color.black, display=True) 
 
        else:  
            Creator.terminal.error("Unknown Seeder action.")