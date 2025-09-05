from app.models.auth.user import User
from main import Creator
# Up function for users seeder
def up(): 
    User.create(**{
        "name":"Khalil",
        "email":"khalil@gmail.com",
        "password" : Creator.hash.make("Kh@lil1234")}
    )
 