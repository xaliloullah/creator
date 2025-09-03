from src.environment import env

name = env('APP_NAME', 'creator')
url = env("APP_URL",'http://localhost')
lang = env("APP_LANG",'en')
key = env("APP_KEY", None)
debug = env("APP_DEBUG", False) 
mode = env("APP_MODE", "console") 
author = "Ibrahima Khaliloullah Thiam"
description = "Creator is a Python project designed to help you build and manage your creative projects efficiently."
# packages= {
#     "mysql-connector-python": "9.0.0",
#     "psycopg2": "2.9.10",
#     "pymongo": "4.10.1",
#     "cryptography": "44.0.0",
#     "bcrypt": "4.2.1",
#     "argparse": "1.4.0",
#     "keyboard": "0.13.5",
#     "markdown": "3.7",
#     "pyyaml": "6.0.2",
#     "PyPDF2": "3.0.1",
#     "pillow": "11.1.0",
#     "deep-translator": "1.11.4",
#     "pyttsx3": "2.99"
# }