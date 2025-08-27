try: 
    from flask import Flask, request, Response
    from routes.route import Route 
    from src.core import render 
except:
    pass

class Http: 

    app = Flask(__name__)

    @app.route("/", defaults={"path": ""}, methods=["GET", "POST", "PUT", "DELETE"])
    @app.route("/<path:path>", methods=["GET", "POST", "PUT", "DELETE"])
    def catch_all(path):
        # 1. Récupère la requête Flask
        method = request.method
        url = "/" + path
        
        # 2. Passe la requête à ton routeur maison
        response = Route.dispatch(method, url, request)
        
        # 3. Si c’est une vue .cre → utiliser ton moteur render()
        if isinstance(response, dict) and "view" in response:
            html = render(response["view"], response.get("context", {}))
            return Response(html, mimetype="text/html")
        
        # 4. Sinon, renvoyer tel quel (JSON, texte, etc.)
        return Response(response, mimetype="application/json")

    @classmethod
    def run_server(cls, host="127.0.0.1", port=5000, debug=True):
        cls.app.run(host=host, port=port, debug=debug)
