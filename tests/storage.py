import sys
import os
 
sys.path.append(os.path.abspath(os.path.join(__file__, "..", "..")))

from src.core import Storage

storage = Storage("test", format="ini", absolute=True) 
# print(storage.dump())
