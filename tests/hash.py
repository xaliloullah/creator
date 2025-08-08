import sys
import os
 
sys.path.append(os.path.abspath(os.path.join(__file__, "..", "..")))

from src.core import Hash


# password = Hash().make("pass") 
password = "$2b$12$wq7RlUESB4SRzmDpMrKZ8ObXFWdpmczlxQW7r5gvrVrbr34gfVAV6"

print(Hash.check("pass", password))