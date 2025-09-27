# import json

# class Response:
#     def __init__(self, content):
#         self.content = content 

#     def alert(self, status, *messages):
#         pass
from typing import Any
from wsgiref.headers import Headers
import json as _json

class Response:
    def __init__(self, body:Any=b"", status=200, headers=None):
        self.body = body if isinstance(body, (bytes, bytearray)) else str(body).encode("utf-8")
        self.status = status
        self.headers = Headers(headers or [])
        if not self.headers.get("Content-Type"):
            self.headers.add_header("Content-Type", "text/plain; charset=utf-8")

    @staticmethod
    def text(data, status=200, headers=None):
        resp = Response(str(data), status, headers)
        resp.headers["Content-Type"] = "text/plain; charset=utf-8"
        return resp

    @staticmethod
    def html(data, status=200, headers=None):
        resp = Response(data, status, headers)
        resp.headers["Content-Type"] = "text/html; charset=utf-8"
        return resp

    @staticmethod
    def json(data, status=200, headers=None):
        resp = Response(_json.dumps(data), status, headers)
        resp.headers["Content-Type"] = "application/json; charset=utf-8"
        return resp

    @staticmethod
    def redirect(location, status=302):
        resp = Response(b"", status)
        resp.headers["Location"] = location
        return resp

    @staticmethod
    def file(path, status=200, headers=None):
        import mimetypes
        import os
        if not os.path.exists(path) or not os.path.isfile(path):
            return Response.text("File not found", 404)
        mime, _ = mimetypes.guess_type(path)
        with open(path, "rb") as f:
            data = f.read()
        resp = Response(data, status, headers)
        resp.headers["Content-Type"] = (mime or "application/octet-stream")
        return resp