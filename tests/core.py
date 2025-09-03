import sys
import os
 
sys.path.append(os.path.abspath(os.path.join(__file__, "..", "..")))

from src.core import View, Path, File, Route, Task

from app.models.auth.user import User


users = User.all()
 
for user in users.get():
    print(user.name.pluralize())