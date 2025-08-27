from src.environment import env

name = env('APP_NAME', 'creator')
url = env("APP_URL",'http://localhost')
lang = env("APP_LANG",'en')
key = env("APP_KEY", None)
debug = env("APP_DEBUG", False) 
mode = env("APP_MODE", "console") 
author = "Ibrahima Khaliloullah Thiam"
description = "Creator is a Python project designed to help you build and manage your creative projects efficiently."