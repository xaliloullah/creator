from main import Creator
from app.models.tools.calculator import Calculator

class CalculatorController:
    from src.contexts.request import Request

    @staticmethod
    def calculator(): 
        calculator = Calculator()
        return Creator.view("layouts.tools.calculator", Creator.view.compact(calculator=calculator))
    
    @staticmethod
    def history():
        calculator = Calculator()
        return calculator.history()

    @classmethod
    def calculate(request:Request, qwery):
        calculator = Calculator()
        return calculator.calculate(qwery)
        