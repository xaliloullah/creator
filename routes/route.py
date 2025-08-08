from src.core import Route
from app.controllers.TestController import TestController
from app.controllers.RouteController import RouteController
from app.controllers.tools.CalculatorController import CalculatorController 


Route.register("main", "main", controller=RouteController)
Route.controller(CalculatorController, lambda :(
    Route.register("tools.calculator", "calculator"),
    Route.register("tools.calculator.calculate", "calculate"),
    Route.register("tools.calculator.history", "history"),
), middleware=["auth"])
Route.resource("tests", TestController) 

from routes import auth