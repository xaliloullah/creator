from src.commands import Command, Creator

class TestCommand(Command):
    @classmethod
    def config(cls, subparsers):
        parser:Command = subparsers.add_parser('test', help="Command to 'Test' something")
        parser_group = parser.add_argument_group("test")
        parser_group.add_argument('--run', action='store_true', help="Run a specific test file or all test files.")  
        parser_group.add_argument('name', nargs='?', help="Name of the test file (optional)") 
        parser_group.add_argument('--list', action='store_true', help="Show all available test files.") 
        parser.set_defaults(func=cls.handle)

    @staticmethod
    def handle(args):
        from src.core.test import Test
        if not any([
            args.run, 
            args.list
        ]):
            args.run = True 
        if args.run: 
            if args.name:
                test = Test.get(args.name) 
                Test(test).run()
            else:
                tests = Test.get()
                for test in tests:
                    Test(test).run()  

        elif args.list: 
            tests = Test.get()
            Creator.terminal.list(tests, icon = Creator.terminal.icon.arrow_right(), margin=3, color = Creator.terminal.color.black, display=True) 
 
        else:  
            Creator.terminal.error("Unknown tests action.")