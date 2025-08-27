from src.core import Session, Request
from src.middlewares import Middleware
from main import Creator


class AuthMiddleware(Middleware): 

    @staticmethod
    def handle(request, next, params=None):
        if not Session().has("user") or not Session().is_active():
            return Creator.route('login')
        return next()