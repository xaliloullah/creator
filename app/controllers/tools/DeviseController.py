from app.models.tools.devise import Devise
from main import Creator


class DeviseController:
    from src.contexts.request import Request



    def convert(request:Request):
        dev = Devise(value=10000, rate='EUR')
        # dev.update()
        dev.convert('XOF')
        print(f"{dev} {dev.get_current().symbol}")
        print(dev.rate.symbol)