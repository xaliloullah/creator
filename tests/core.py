from src.core import View, Path, File, Route, Task

# from app.models.auth.user import User


# users = User.all()
 
# for user in users.get():
#     print(user.name.pluralize())


file = File(".env")
# file.set_extension("erze")
# print(file.path)
# def set_extension(path: str, extension: str) -> str:  
#     if not extension.startswith("."):
#         extension = "." + extension 
#     dot_index = path.rfind(".")

#     if dot_index == -1 or "/" in path[dot_index:] or "\\" in path[dot_index:]: 
#         return path + extension
#     else: 
#         return path[:dot_index] + extension


# Exemple d'utilisation
print(file.set_extension("csv").path)   # -> dossier/fichier.csv
print(file.set_extension(".png").path)           # -> photo.png
print(file.set_extension("md").path)                 # -> README.md
