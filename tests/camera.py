import sys
import os
 
sys.path.append(os.path.abspath(os.path.join(__file__, "..", "..")))
 

from src.application.configs import Settings

from src.core import Storage, File, Path, Crypt 
 
print(Crypt.decrypt("gAAAAABovwYD7fLF5fhLFMO5n37T6V-YShVBT4IZ0ApO_onawmsmuZ44v5K1leBZYT-UpUY4PT5kJxG1ctkPfUaSMYdEOGCFBQ=="))