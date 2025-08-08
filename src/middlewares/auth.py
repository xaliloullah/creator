from src.application.contexts import Session
from main import Creator

class AuthMiddleware: 

    def handle(self, request, next, **kwargs):
        if not Session().has("user") or not Session().is_active():
            return Creator.route('login')
        return next(request, **kwargs)