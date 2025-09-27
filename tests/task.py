# Auto-generated test for task
from src.core import Task
from src.console import Terminal 
import time
def test_terminal():
    # Test 'task' functionality.
    # TODO: Add assertions here
    # Terminal.animation = True 
    Task.do(Terminal.animation().loader, spinner="blocks")
    # time.sleep(5)
    # Terminal.animation = False
    # thread.join()  
    Terminal.print("Salut ceci est un test : ", color="red", icon="plus", font="underline, bold", margin="1, 1")
    import time 
    time.sleep(1)
