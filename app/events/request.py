from src.core import Event  
from main import Creator

class Request(Event): 

    @staticmethod
    def callback(): 
        print("Request event triggered")

    Event.listen("request", callback)