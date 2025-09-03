from src.middlewares import Middleware 
from src.core import Request
from app.models.auth.user import User
from main import Creator

class AppMiddleware(Middleware):

    @staticmethod
    def handle(request: Request, next: callable): 
        if request.user:
            user = User.where(id=request.user.id).first()
            session = Creator.SESSION.where(user_id=user.id).first() 
            if session is None or session.is_expired():
                session = Creator.SESSION.create(user_id=user.id) 
            session.put('user_id', user.id)  
        else: 
            if not getattr(request, 'session', None):
                request.session = Creator.SESSION.create() 
        if not hasattr(request, 'session'):
            request.session = session

        return next()
