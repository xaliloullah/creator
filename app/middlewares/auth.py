from typing import Callable
from src.core import Middleware 
from src.core import Request
from main import Creator


class AuthMiddleware(Middleware): 

    @staticmethod
    def handle(request: Request, next: Callable):
        # if not request.session.has("user_id") or request.session.is_expired():
        #     return Creator.redirect.route('login')  
        return next(request)