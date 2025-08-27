class Middleware:
    """
    Base class for middlewares.
    """
    def __init__(self, app):
        self.app = app

    def process_request(self, request):
        """
        Process the request before it reaches the view.
        """
        pass

    def process_response(self, response):
        """
        Process the response before it is sent to the client.
        """
        return response
    
    def process_exception(self, exception):
        """
        Process any exceptions that occur during request handling.
        """
        return self.app.handle_exception(exception)