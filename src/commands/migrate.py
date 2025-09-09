from src.commands import Command, Creator 
import traceback

class MigrateCommand(Command):
    @classmethod
    def config(cls, subparsers): 
        # 'migrate' command
        parser:Command = subparsers.add_parser('migrate', help="Migration actions")
        parser_group = parser.add_argument_group("migrate")
        parser_group.add_argument('--run', action='store_true', help="Run the migrations")
        parser_group.add_argument('--rollback', action='store_true', help="Rollback the last migration")
        parser_group.add_argument('--check', action='store_true', help="Check the migration status")
        parser_group.add_argument('--list', action='store_true', help="List all migrations")
        parser_group.add_argument('--fresh', action='store_true', help="Fresh migration")
        parser_group.add_argument('--drop', action='store_true', help="Drop all migrations")
        
        parser.set_defaults(func=cls.handle) 

    @staticmethod
    def handle(args):
        from src.databases.migration import Migration
        if not any([
            args.run,
            args.rollback,
            args.check,
            args.list,
            args.fresh,
            args.drop
        ]):
            args.run = True
        """Execute migration actions.""" 
        
        if args.run:
            Creator.terminal.info(Creator.lang.get("info.run", resource="migration")) 
            Migration.migrate()

        elif args.rollback:
            Creator.terminal.info(Creator.lang.get("info.rollback", resource="migration"))
            Migration.migrate('down')

        elif args.check:
            Creator.terminal.info(Creator.lang.get("info.check", resource="migration")) 
            migrations = Migration.check()
            Creator.terminal.list(migrations, icon = Creator.terminal.icon.light_check(), margin=3, display=True) 

        elif args.list:
            Creator.terminal.info(Creator.lang.get("info.list", resource="migration"))
            migrations = Migration.get()
            Creator.terminal.list(migrations, icon = Creator.terminal.icon.arrow_right(), margin=3, color = Creator.terminal.color.black, display=True) 

        elif args.fresh:
            Creator.terminal.info(Creator.lang.get("info.fresh", resource="migration"))
            # Migration.migrate('down')
            Migration.drop_all()
            Migration.migrate()
            
        elif args.drop:
            Creator.terminal.info(Creator.lang.get("info.drop", resource="migration"))
            Migration.down()  
        else:  
            Creator.terminal.error("Unknown migration action.")
 
          