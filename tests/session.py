import sys
import os
 
sys.path.append(os.path.abspath(os.path.join(__file__, "..", "..")))

from src.application.contexts import Session


print(Session().is_active())

 
