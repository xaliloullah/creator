import sys
import os
 
sys.path.append(os.path.abspath(os.path.join(__file__, "..", "..")))

from src.core import Route
from app.controllers.TestController import TestController
from app.controllers.RouteController import RouteController
from app.controllers.tools.CalculatorController import CalculatorController


Route.group( lambda:{
Route.register("main", "main", controller=RouteController),
Route.controller(CalculatorController, lambda :(
    Route.register("calculator", "calculator"),
    Route.register("calculate", "calculate"),
    Route.register("history", "history"),
)), 
Route.resource("tests", TestController)}
)    

print(Route.list())
# from main import Creator

# # Creator.configure(
# #         main="main"
# #     )

# Creator.route("tests.create")
 