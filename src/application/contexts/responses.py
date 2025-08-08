# src/core/http.py
import json

class Response:
    def __init__(self, content="", status=200, headers=None, content_type="text/html"):
        self.content = content
        self.status = status
        self.headers = headers or {}
        self.content_type = content_type

        # Définir le Content-Type par défaut
        self.headers.setdefault("Content-Type", self.content_type)

    def set_header(self, key, value):
        """Ajoute ou modifie un en-tête HTTP."""
        self.headers[key] = value
        return self

    def set_status(self, status_code):
        """Modifie le code HTTP."""
        self.status = status_code
        return self

    def json(self, data, status=200):
        """Retourne une réponse JSON."""
        self.content = json.dumps(data, ensure_ascii=False)
        self.status = status
        self.content_type = "application/json"
        self.headers["Content-Type"] = self.content_type
        return self

    def text(self, data, status=200):
        """Retourne une réponse texte brute."""
        self.content = str(data)
        self.status = status
        self.content_type = "text/plain"
        self.headers["Content-Type"] = self.content_type
        return self

    def html(self, html_content, status=200):
        """Retourne une réponse HTML."""
        self.content = html_content
        self.status = status
        self.content_type = "text/html"
        self.headers["Content-Type"] = self.content_type
        return self

    def send(self):
        """
        Prépare la réponse pour l'envoi.
        Dans un vrai serveur, ici on écrirait vers le socket HTTP.
        """
        return {
            "status": self.status,
            "headers": self.headers,
            "body": self.content
        }

    def __str__(self):
        return f"HTTP {self.status} | {self.headers} | {self.content[:50]}"
