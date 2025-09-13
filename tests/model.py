import sys
import os
 
sys.path.append(os.path.abspath(os.path.join(__file__, "..", "..")))

# from app.models.auth.user import User
from app.models.auth.user import User 


user = User.where(id=1, name="Khalil").where_not(name="ka", id=2).like(name="lil").order_by()

print(user) 
print(user.provider.generate_script()) 