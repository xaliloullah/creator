from src.commands import Command, Creator 
from src.servers import Server


class ServerCommand(Command):
    @classmethod
    def config(cls, subparsers):
        parser:Command = subparsers.add_parser('serve', help="Start a simple server")
        parser.add_argument('-p','--port', type=int, default=8000, help="Port to run the server on")
        parser.add_argument('-H', '--host', type=str, default='127.0.0.1', help="Host to run the server on (default: localhost)") 
        parser.add_argument('-d','--directory', help="Directory to serve files from (default: current working directory)")
        parser.set_defaults(func=cls.handle)
        

    @staticmethod
    def handle(args): 
        server = Server(host=args.host, port=args.port)
        server.run() 
        Creator.terminal.success(f"Server running on port: {server.port}. URL: http://{server.host}:{server.port}")
        try:
            while True:
                pass
        except KeyboardInterrupt:
            Creator.terminal.warning(f"Stopping the server...")  
            server.stop() 
