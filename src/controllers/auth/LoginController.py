from main import Creator  
from src.models.auth import Auth
from app.models.user import User
from src.validators import Rule

class LoginController:
    from src.application.contexts import Request

    @staticmethod
    def index():
        #
        return

    @staticmethod
    def create():
        #
        return Creator.view("auth.login")

    @staticmethod
    def store(request: Request):
        if request.validate({
                # 'email': ["required","email"], #"unique:users"
                'name': Rule().required().string(),  
                'password': Rule().required().string()
            }):    
            user = User().where(name=request['name']).first() 
            if Auth.authenticate(user):
                request.session.success(Creator.lang.get('auth.succeeded'))
                return Creator.route('dashboard')
            else:
                request.session.error(Creator.lang.get('auth.failed'))  
        
            return Creator.view.back()
    
    @staticmethod
    def edit(id):
        #
        return

    @staticmethod
    def update(request: Request, id):
        #
        return

    @staticmethod
    def show(id):
        #
        return

    @staticmethod
    def destroy(id):
        #
        return
    