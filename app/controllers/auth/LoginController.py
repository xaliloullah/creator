from main import Creator  

from app.models.auth.user import User
from src.validators import Rule

class LoginController:
    from src.core import Request
 
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
            # credentials = [request.all()]
            user = User.where(name=request.name).first() 
            if user and Creator.hash.check(request.password, user.password): 
                request.user = user  
                request.session.success(Creator.lang.get('auth.succeeded'))
                # Auth.login(user)
                return Creator.route('dashboard')
            else:
                request.session.error(Creator.lang.get('auth.failed'))  
                return Creator.view.back()

    @staticmethod
    def destroy(request: Request):
        request.session.destroy()
        return Creator.route('login')

    