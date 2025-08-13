from main import Creator 

class TestController:
    from src.core import Request    
    
    @staticmethod
    def index(): 
        return Creator.view("layouts.tests.index")

    @staticmethod
    def create():
        return Creator.view("layouts.tests.create")

    @staticmethod 
    def store(request: Request):
        # if request.validate(
        #     {"name":["require"]}
        # ):
        # name = request.name
        # print("request.data")
        print(request.data)
        return 

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