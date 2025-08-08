import sys
import os
 
sys.path.append(os.path.abspath(os.path.join(__file__, "..", "..")))

from src.core import View, Path, File
# from src.validators import Rule, Validator
# from src.apps.contexts import Request, Session

# request = Request({"name":"data ", "age":999}, session=Session(), validator=Validator())
# test = request.validate({"name":Rule().string().minlength(5),
#     "age":Rule().min(10).max(100).integer()
#     }) 

# print(request.data)
# print(request.session.get_errors())
# File("test").save(File.make_structure())
# print(File.make_structure())
 

View("layouts.tests.create")
View("layouts.tests.index")
View("layouts.tests.create")
View("layouts.tests.index")

print(View.history)

View.back()
print(View.history)
print(View.data)
 