from wsgiref.simple_server import make_server
import threading

from main import Creator
class Server:
    def __init__(self, host="127.0.0.1", port=8000, app=None):
        self.host = host
        self.port = port
        self.app = app or self.default_app
        self.httpd = None
        self.thread = None

    def default_app(self, environ, start_response): 
        start_response("200 OK", [("Content-Type", "text/html; charset=utf-8")])
        html = Creator.file('C:/creator/Projets/Python/creator/tests/index.html', format="html").load()
        return [html.encode("utf-8")]
        # return [b"Bonjour depuis le serveur WSGI !"]

    def run(self): 
        if self.httpd is not None:
            print("Le serveur est déjà en cours d'exécution.")
            return

        self.httpd = make_server(self.host, self.port, self.app)

        def serve(): 
            self.httpd.serve_forever()

        self.thread = threading.Thread(target=serve, daemon=True)
        self.thread.start()

    def stop(self): 
        if self.httpd: 
            self.httpd.shutdown()
            self.httpd.server_close()
            self.httpd = None
            self.thread = None 
        else:
            print("Le serveur n'est pas en cours d'exécution.")
