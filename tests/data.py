import sys
import os
 
sys.path.append(os.path.abspath(os.path.join(__file__, "..", "..")))

from src.core import Data

data = Data({'test':'all'}, format="ini")

print(data.dump())
