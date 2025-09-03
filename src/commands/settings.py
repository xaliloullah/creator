from src.commands import Command, Creator

class SettingCommand(Command):
    @classmethod
    def config(cls, subparsers):
        parser:Command = subparsers.add_parser('settings', help="Command to 'settings' creator") 
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

        parser.set_defaults(func=cls.handle)

    @staticmethod
    def handle(args):
        if args.database: 
            driver = Creator.terminal.input(Creator.lang.get("info.options", resource=f"database"), type="select", options=Creator.settings.get("databases"), value=Creator.database, inline=False) 
            # databases = Creator.data(Creator.build.Env.database(driver=driver, name=Creator.name, path=Creator.path.databases()), "env").get()
            # env = Creator.storage('.env', absolute=False, format="env")
            # collect = Creator.collection(env)  
         
            # print(collect.get())
            # for key, value in databases.items(): 
            #     collect.set(key, value) 
            # print(collect.get())
            # env.save(collect.get()) 
            # if args.driver: 
            #     if args.driver in Creator.settings.get("databases"): 
            # else:
            #     Creator.terminal.warning(Creator.lang.get("warning.options", resource=f"database"))

        elif args.lang: 
            if args.set:
                if args.set in Creator.settings.get("langs"): 
                    env = Creator.storage('.env', absolute=False, format="env")
                    collect = Creator.collection(env)  
                    collect.set("APP_LANG", args.set) 
                    env.save(collect.get()) 
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