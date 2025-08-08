from app.models.user import User
from src.application.contexts import Session
class Auth:

    @staticmethod
    def authenticate(user:User):
        Session().set('user_id', user['id'])

    @staticmethod
    def regenerate(user:User):
        Session().create(user['id'])

    
