from src.core import Route

from src.controllers.auth.LoginController import LoginController
from src.controllers.auth.RegisterController import RegisterController

Route.get('/login', 'create', controller=LoginController) 
Route.post('/login/store', 'store', controller=LoginController)
Route.delete('/logout', 'destroy',controller=LoginController)
Route.get('/register', 'create',controller=RegisterController) 
Route.post('/register.store', 'store', controller=RegisterController)  