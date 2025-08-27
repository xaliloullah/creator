from src.models import Model

class User(Model):
    def __init__(self):
        self.table = 'users' 
        super().__init__(self.table)
        # 