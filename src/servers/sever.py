from flask import Flask, request, Response
import threading 
from routes.route import Route
from main import Creator
class Server:
    def __init__(self, host="127.0.0.1", port=8000):
        self.host = host
        self.port = port
        self.app = Flask(__name__)
        self.httpd = None
        self.thread = None 
        self.debug = Creator.debug 
        self.setup()


    def setup(self):
        for uri, meta in Route.list().items():
            methods = [meta["method"]]
            def view_func(meta=meta):
                # controller_kwargs = {k: v for k, v in meta.items() if k not in ["uri", "name", "method"]}
                return Route.dispatch(meta["name"])
            
            self.app.add_url_rule(
                meta["uri"],
                endpoint=meta["name"],
                view_func=view_func,
                methods=methods
            )


        

    def run(self): 
        if self.thread is not None and self.thread.is_alive():
            # print("Le serveur est déjà en cours d'exécution.")
            return

        def serve():
            self.app.run(host=self.host, port=self.port, debug=self.debug, use_reloader=False)

        self.thread = threading.Thread(target=serve, daemon=True)
        self.thread.start()

    def stop(self):    
        if self.httpd: 
            self.thread.join()
            self.httpd = None
            self.thread = None