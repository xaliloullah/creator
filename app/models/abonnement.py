from src.databases.model import Model

class Abonnement(Model): 
    table = 'abonnements'
    #

    def user(self):
        from app.models.auth.user import User
        return self.has_one(User, 'user_id')