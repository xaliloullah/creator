from src.core import Route
from src.controllers.auth.LoginController import LoginController
from src.controllers.auth.RegisterController import RegisterController
Route.register('login', 'create', controller=LoginController) 
Route.register('login.store', 'store',controller=LoginController)
Route.register('register', 'create',controller=RegisterController) 
Route.register('register.store', 'store',controller=RegisterController)  