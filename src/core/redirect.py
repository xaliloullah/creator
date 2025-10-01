from src.core import View, Request, Route

class Redirect:
    
    @classmethod
    def route(cls, route, **kwargs):  
        Request().send(route, **kwargs) 

    @classmethod
    def view(cls, view, **kwargs):
        return View(view, **kwargs) 
    
    @classmethod
    def back(cls):  
        previous, kwargs = Route.previous()
        if previous:
            Request().send(previous, **kwargs) 
        
    @classmethod
    def refresh(cls): 
        current, kwargs = Route.current()
        if current:
            View.show(current, **kwargs) 
        
    