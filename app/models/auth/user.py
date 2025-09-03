from src.models import Model
from src.core import String
class User(Model):
    table = 'users'  
    #  
    casts = {
        'name':String
    }
    def zolobay(self):
        return "yes"