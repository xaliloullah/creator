from app.models.user import User
from src.application.contexts import Session
class Auth:

    @staticmethod
    def authenticate(user:User):
        if user:
            return Session().set('user_id', user['id'])
        return False    

    @staticmethod
    def regenerate(user:User):
        if user:
            return Session().create(user['id'])
        return False

    
