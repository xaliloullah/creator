from app.models.auth.user import User
from src.core import Request
 
class Auth: 
    
    user:User=None

    @classmethod
    def config(cls, **kwargs):
        user:User = kwargs.get('user')
        request:Request = kwargs.get('request', None)

    @classmethod
    def login(cls, user:User):
        cls.user = user 
    
    @classmethod
    def authenticate(cls, user:User):
        pass
    
    @staticmethod
    def regenerate(user:User):
        if user:
            return Auth.session.create(user['id'])
        return False

    
