from app.models.user import User
from src.application import Creator 


class Auth:
    session = Creator.request.session
    user:User=None


    @classmethod
    def authenticate(cls, user:User):
        if user and cls.session.is_active():
            cls.user = user
            cls.session.set('user_id', user['id']) 
            cls.session.update()

    @staticmethod
    def regenerate(user:User):
        if user:
            return Auth.session.create(user['id'])
        return False

    
