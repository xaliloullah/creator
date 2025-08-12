from main import Creator


class RouteController:
    from src.contexts.request import Request


    def main():
        return Creator.view("layouts.main")
    
    
    def dashboard():
        return Creator.view("dashboard")