from typing import Callable
from src.middlewares import Middleware 
from src.core import Request
from app.models.auth.user import User
from main import Creator


class AppMiddleware(Middleware):

    @staticmethod
    def handle(request: Request, next: Callable):
        session = request.session 

        if session.has('user_id'):
            user = User.where(id=session.get('user_id')).first()
            if user:
                request.user = user 
                if session.is_expired():
                    request.session = Creator.session.create(user_id=user.id) 
            else: 
                request.session.destroy()

        # return next(request)
        return next()
