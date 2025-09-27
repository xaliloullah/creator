from src.core import View

class Redirect:
    @classmethod
    def route(cls, route, **kwargs):
        from routes.route import Route
        Route.dispatch(route, **kwargs) 

    @classmethod
    def uri(cls, uri, **kwargs):
        pass

    @classmethod
    def view(cls, view, **kwargs):
        return View(view, *kwargs) 