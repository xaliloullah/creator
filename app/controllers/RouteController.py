from main import Creator


class RouteController:
    from src.core import Request
    @staticmethod
    def main():
        # if Creator.request.session.has('last_route'):
        #     return Creator.route(Creator.request.session.get('last_route'))
        return Creator.view("layouts.main")
    
    
    @staticmethod
    def dashboard():
        return Creator.view("dashboard")