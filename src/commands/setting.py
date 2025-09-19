from src.commands import Command, Creator

class SettingCommand(Command):
    @classmethod
    def config(cls, subparsers):
        parser:Command = subparsers.add_parser('setting', help="Command to 'settings' creator") 
        parser.add_argument('--database', '--db', action='store_true', help="An optional argument for the command")
        database_parser = parser.add_argument_group("database")
        database_parser.add_argument('--driver', '-d', help="Specify the driver for the database")
        database_parser.add_argument('-p','--port', help="Specify the port for the database") 

        parser.add_argument('--lang', action='store_true', help="An optional argument for the command")
        lang_parser = parser.add_argument_group("lang") 
        lang_parser.add_argument("--set", help="Set the language (e.g., fr, en)", type=str)
        lang_parser.add_argument("--list", help="List available languages", action="store_true")
        lang_parser.add_argument("--check", help="Check a specific language", type=str)
        lang_parser.add_argument("--generate", help="Generate language files", type=str)

        parser.add_argument('--key', choices=['get', 'generate'], nargs='?', const='get', help="An optional argument for the command") 
        parser.add_argument('--mode', choices=['console', 'desktop', 'web'], help="An optional argument for the command") 
        parser.set_defaults(func=cls.handle)

    @staticmethod
    def handle(args):
         
        if args.database: 
            from config import app, database
            driver = Creator.terminal.input(Creator.lang.get("info.options", resource=f"database"), type="select", options=database.supported, value=Creator.database, inline=False)
            env_database = Creator.build.Env.database(driver=driver, name=app.name, path=Creator.path.databases())  
            from src.core import Data 
            env_database = Data(env_database, format='env').get()
            for key, value in env_database.items():
                Creator.settings.env().set(key, value)    
            Creator.terminal.success(Creator.lang.get("success.process"))

        elif args.lang:
            if args.set:
                if args.set in Creator.settings.get("langs"): 
                    Creator.settings.env().set("APP_LANG", args.set)    
                    Creator.terminal.success(Creator.lang.get("success.process"))
                else:
                    Creator.terminal.error(Creator.lang.get("error.invalid", data=f"{args.set}"))
            elif args.list:
                Creator.terminal.list(Creator.lang.languages, display=True)
            elif args.check: 
                Creator.terminal.info(Creator.lang.check(args.check))
            elif args.generate:
                Creator.generate_lang(args.generate)
            else:
                return Creator.terminal.error(Creator.lang.get("error.invalid", data=f"{args.set}"))
            
        elif args.key:
            if args.key == 'get':
                Creator.terminal.label(Creator.key)
            elif args.key == 'generate':
                Creator.settings.env().set('APP_KEY', Creator.hash.generate_key())
        elif args.mode:
            Creator.settings.env().set('APP_MODE', args.mode) 