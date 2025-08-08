from src.environment import env

name = env('APP_NAME', 'creator')
url = env("APP_URL",'http://localhost')
lang = env("APP_LANG",'en')
key = env("APP_KEY", None)
debug = env("APP_DEBUG", False) 
mode = env("APP_MODE", "console") 
author = "Ibrahima Khaliloullah Thiam"
description = "Creator is a versatile Python framework designed to streamline the development process by providing a comprehensive set of tools and libraries. It supports various databases including MySQL, PostgreSQL, and MongoDB, and offers functionalities for encryption, argument parsing, keyboard interactions, markdown processing, YAML parsing, PDF manipulation, and image processing. The framework is built to be compatible with Python 3.12.4 and includes a wide range of packages to facilitate rapid application development."