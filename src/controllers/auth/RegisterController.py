from main import Creator   
from src.validators import Rule
from src.models.auth import Auth
from app.models.user import User

class RegisterController:
    from src.application.contexts import Request

    
    @staticmethod
    def index():
        #
        return

    @staticmethod
    @Creator.view.extend("app")
    @Creator.view.section("title", "REGISTER") 
    @Creator.view.section("content")
    def create():
        #
        return Creator.view("auth.register")

    @staticmethod
    def store(request: Request):
        if request.validate({
            'name': Rule().required().string().min(3).max(50).unique('users'),  
            'email': Rule().required().email().unique('users'),  
            'password': Rule().password()
        }):
            user = User()
            user.create(
                name = request['name'],
                email = request['email'],
                password = Creator.hash.make(request['password'])
            ) 
            if Auth.regenerate(user):
                Creator.request.session.success(Creator.lang.get('auth.succeeded'))
                return Creator.route('dashboard')
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
        user = User().find(id) 
        user.delete() 
    
        Creator.request.session.success("Supprimer avec succees")
        return Creator.view.back() 
    