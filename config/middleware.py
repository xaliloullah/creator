from src.middlewares.middleware import Middleware
from src.middlewares.auth import AuthMiddleware 

Middleware.register("auth", AuthMiddleware)
# Middleware.register("log", LogMiddleware)