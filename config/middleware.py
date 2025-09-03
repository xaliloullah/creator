from src.middlewares.middleware import Middleware
from app.middlewares.app import AppMiddleware 
from app.middlewares.auth import AuthMiddleware 

Middleware.register("app", AppMiddleware)
Middleware.register("auth", AuthMiddleware)
# Middleware.register("log", LogMiddleware)