from src.core import Session, Structure

def test_session():

    # Test 'session' functionality.

    # TODO: Add assertions here

    session = Session() 

    session.set("keys.key", "value", autosave=False) 
