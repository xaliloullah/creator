import sys
import os
 
sys.path.append(os.path.abspath(os.path.join(__file__, "..", "..")))

# from app.models.auth.user import User
from src.models.model import Model

class User(Model): 
    pass

users = User.all()
print(users)
# for user in users:
#     print(user)