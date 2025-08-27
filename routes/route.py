from src.core import Route 
from app.controllers.RouteController import RouteController 


Route.get("/", "main", controller=RouteController, name='main')
Route.get("/dashboard", "dashboard", controller=RouteController)

from routes import auth