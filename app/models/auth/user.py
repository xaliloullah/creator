from src.databases.model import Model
from src.core import String

class User(Model):
    table = 'users'  
    #
    casts = {
        'name':String
    }

    def abonnements(self):
        from app.models.abonnement import Abonnement
        return self.has_many(Abonnement, 'user_id')