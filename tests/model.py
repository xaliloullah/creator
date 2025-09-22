from src.databases.model import Model

def test_model():
    Model.table = 'users'

    Model.all()