import sys
import os
 
sys.path.append(os.path.abspath(os.path.join(__file__, "..", "..")))

from src.core import View, Path, File, Route
# # from main import Creator
 
 
# path = Path('te :#ù%st/l-xo  gi n ', prefix="admin" , safe=True)
# print(path.name())
Route.group(lambda: {
            Route.register('login', 'login'), 
            Route.register('register', 'register')},
            prefix='user', middleware=['auth', 'verify'])

Route.register('test&?sdfdsf', 'action', middleware=['auth', 'log'], prefix='admin')

print(Route.resolve('login'))