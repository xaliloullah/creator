import sys
import os
 
sys.path.append(os.path.abspath(os.path.join(__file__, "..", "..")))

from src.application.contexts import Session
session = Session()
session.set("user_id", 1)
session.update()  

 
