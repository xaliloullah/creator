from src.databases.model import Model
from src.core import String
class User(Model):
    table = 'users'  
    #
    casts = {
        'name':String
    }
    def zolobay(self):
        return "yes"