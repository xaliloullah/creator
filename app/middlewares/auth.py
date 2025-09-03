from src.middlewares import Middleware 
from src.core import Request
from main import Creator


class AuthMiddleware(Middleware): 

    @staticmethod
    def handle(request: Request, next: callable):
        if not request.session.has("user_id") or request.session.is_expired():
            return Creator.route('login')  
        return next()