from src.core import Route

from app.controllers.auth.LoginController import LoginController
from app.controllers.auth.RegisterController import RegisterController

Route.get('/login', 'create', controller=LoginController, name="login") 
Route.post('/login/store', 'store', controller=LoginController, name="login.store")
Route.delete('/logout', 'destroy',controller=LoginController, name="logout")
Route.get('/register', 'create',controller=RegisterController, name="register") 
Route.post('/register.store', 'store', controller=RegisterController, name="register.store")  