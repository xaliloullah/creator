from src.commands import Command, Creator 
from src.servers import Server
from config import app

class ServerCommand(Command):
    @classmethod
    def config(cls, subparsers):
        parser:Command = subparsers.add_parser('serve', help="Start a simple server")
        parser.add_argument('-p','--port', type=int, default=app.port, help="Port to run the server on")
        parser.add_argument('-H', '--host', type=str, default=app.host, help="Host to run the server on (default: localhost)") 
        parser.add_argument('-d','--directory', help="Directory to serve files from (default: current working directory)")
        parser.set_defaults(func=cls.handle)
        

    @staticmethod
    def handle(args): 
        server = Server(host=args.host, port=args.port)
        Creator.terminal.success(f"Server running on {server.host}:{server.port}")
        server.start() 
        # 
        Creator.terminal.warning(f"Stopping the server...")
