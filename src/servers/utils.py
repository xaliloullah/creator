from wsgiref.simple_server import make_server
from wsgiref.headers import Headers
from urllib.parse import parse_qs
from string import Template
import json as _json
import mimetypes
import re
import os
import traceback


# -----------------------------
# Request & Response
# -----------------------------
class Request:
    def __init__(self, environ):
        self.environ = environ
        self.method = environ.get("REQUEST_METHOD", "GET").upper()
        self.url = f"{environ.get('wsgi.url_scheme','http')}://{environ.get('HTTP_HOST','localhost')}{environ.get('RAW_URI', environ.get('REQUEST_URI', environ.get('PATH_INFO','/')))}"
        self.path = environ.get("PATH_INFO", "/")
        self.query_string = environ.get("QUERY_STRING", "")
        self.query = {k: v[0] if len(v)==1 else v for k, v in parse_qs(self.query_string, keep_blank_values=True).items()}
        self.headers = {k[5:].replace('_','-').title(): v for k, v in environ.items() if k.startswith('HTTP_')}
        self.content_type = environ.get("CONTENT_TYPE", "")
        self.content_length = int(environ.get("CONTENT_LENGTH", 0) or 0)
        self._body = None
        self._json = None
        self._form = None
        self.params = {}

    @property
    def body(self):
        if self._body is None:
            self._body = self.environ["wsgi.input"].read(self.content_length) if self.content_length else b""
        return self._body

    @property
    def text(self):
        return self.body.decode(self._charset())

    def _charset(self):
        if "charset=" in self.content_type:
            return self.content_type.split("charset=")[-1]
        return "utf-8"

    @property
    def json(self):
        if self._json is None:
            try:
                self._json = _json.loads(self.text) if self.text else None
            except Exception:
                self._json = None
        return self._json

    @property
    def form(self):
        if self._form is None:
            if self.content_type.startswith("application/x-www-form-urlencoded"):
                self._form = {k: v[0] if len(v)==1 else v for k, v in parse_qs(self.text, keep_blank_values=True).items()}
            else:
                self._form = {}
        return self._form


class Response:
    def __init__(self, body=b"", status=200, headers=None):
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
        if not os.path.exists(path) or not os.path.isfile(path):
            return Response.text("File not found", 404)
        mime, _ = mimetypes.guess_type(path)
        with open(path, "rb") as f:
            data = f.read()
        resp = Response(data, status, headers)
        resp.headers["Content-Type"] = (mime or "application/octet-stream")
        return resp


# -----------------------------
# Router & App
# -----------------------------
class Route:
    def __init__(self, pattern, methods, handler):
        self.pattern = self._compile(pattern)
        self.template = pattern
        self.methods = set(m.upper() for m in methods)
        self.handler = handler

    def _compile(self, pattern):
        regex = re.sub(r"<([a-zA-Z_][a-zA-Z0-9_]*)>", r"(?P<\1>[^/]+)", pattern)
        return re.compile(f"^{regex}$")

    def match(self, path):
        m = self.pattern.match(path)
        return m.groupdict() if m else None


class Creator:
    def __init__(self, name=__name__, template_dir="templates"):
        self.name = name
        self.routes = []
        self.middlewares = []
        self.error_handlers = {}
        self.template_dir = template_dir
        self.static_mounts = []

    # Routing
    def route(self, pattern, methods=("GET",)):
        def decorator(fn):
            self.routes.append(Route(pattern, methods, fn))
            return fn
        return decorator

    # Errors
    def error(self, status_code):
        def decorator(fn):
            self.error_handlers[int(status_code)] = fn
            return fn
        return decorator

    # Middleware
    def use(self, middleware):
        self.middlewares.append(middleware)

    # Static
    def static(self, url_prefix, dir):
        self.static_mounts.append((url_prefix.rstrip('/'), os.path.abspath(dir)))

    # Templates
    def render_template(self, filename, **ctx):
        path = os.path.join(self.template_dir, filename)
        with open(path, "r", encoding="utf-8") as f:
            tpl = Template(f.read())
        return Response.html(tpl.safe_substitute(**ctx))


# -----------------------------
# Server: sépare la logique WSGI et run()
# -----------------------------
class Server:
    def __init__(self, app: Creator):
        self.app = app

    def __call__(self, environ, start_response):
        req = Request(environ)

        # Static
        for prefix, folder in self.app.static_mounts:
            if req.path.startswith(prefix + "/") or req.path == prefix:
                rel = req.path[len(prefix):].lstrip("/")
                file_path = os.path.join(folder, rel)
                resp = Response.file(file_path)
                return self._finish(start_response, resp)

        # Routes
        for route in self.app.routes:
            params = route.match(req.path)
            if params is not None and req.method in route.methods:
                req.params = params
                try:
                    handler = self._apply_middlewares(route.handler)
                    resp = handler(req)
                except Exception as e:
                    handler500 = self.app.error_handlers.get(500)
                    if handler500:
                        try:
                            resp = handler500(req, e)
                        except Exception:
                            resp = self._default_500(req, e)
                    else:
                        resp = self._default_500(req, e)
                return self._finish(start_response, self._ensure_response(resp))

        # Not found
        handler404 = self.app.error_handlers.get(404)
        if handler404:
            resp = handler404(req)
        else:
            resp = Response.text("Not Found", 404)
        return self._finish(start_response, resp)

    def _apply_middlewares(self, final_handler):
        def wrap(handler, middleware):
            def new_handler(req):
                return middleware(req, handler)
            return new_handler
        h = final_handler
        for m in reversed(self.app.middlewares):
            h = wrap(h, m)
        return h

    def _ensure_response(self, resp):
        if isinstance(resp, Response):
            return resp
        if isinstance(resp, tuple):
            body, status, headers = (resp + (None, None, None))[:3]
            if isinstance(body, (dict, list)):
                return Response.json(body, status or 200, headers)
            return Response(body or b"", status or 200, headers)
        if isinstance(resp, (dict, list)):
            return Response.json(resp)
        return Response(resp)

    def _finish(self, start_response, resp: Response):
        status_line = f"{resp.status} {self._status_text(resp.status)}"
        start_response(status_line, list(resp.headers.items()))
        return [resp.body]

    @staticmethod
    def _status_text(code):
        mapping = {200:"OK",201:"Created",204:"No Content",302:"Found",
                   400:"Bad Request",401:"Unauthorized",403:"Forbidden",
                   404:"Not Found",500:"Internal Server Error"}
        return mapping.get(code, "OK")

    @staticmethod
    def _default_500(req, err):
        body = f"<h1>500</h1><pre>{traceback.format_exc()}</pre>"
        return Response.html(body, 500)

    # Dev server
    def run(self, host="127.0.0.1", port=5000):
        with make_server(host, port, self) as httpd:
            print(f"* Running on http://{host}:{port} (Press CTRL+C to quit)")
            httpd.serve_forever()




Server(Creator()).run()
