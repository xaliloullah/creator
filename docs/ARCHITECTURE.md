├── .env
├── .gitignore
├── app
│   ├── controllers
│   │   ├── games
│   │   │   ├── CwarController.py
│   │   │   └── DevineController.py
│   │   ├── RouteController.py
│   │   ├── TestController.py
│   │   ├── tools
│   │   │   ├── CalculatorController.py
│   │   │   └── DeviseController.py
│   │   └── UserController.py
│   └── models
│       ├── games
│       │   ├── cwar
│       │   │   ├── .md
│       │   │   ├── building.py
│       │   │   ├── entity.py
│       │   │   ├── player.py
│       │   │   ├── resource.py
│       │   │   ├── unity.py
│       │   │   └── world.py
│       │   ├── cwg.py
│       │   └── devine.py
│       ├── tools
│       │   ├── calculator.py
│       │   └── devise.py
│       └── user.py
├── config
│   ├── app.py
│   ├── command.py
│   ├── database.py
│   ├── log.py
│   ├── middleware.py
│   └── session.py
├── creator
├── databases
│   ├── creator.db
│   ├── migrations
│   │   └── 2025_08_08_create_users_table.py
│   └── seeds
│       ├── test.py
│       └── users.py
├── docs
│   ├── ARCHITECTURE.md
│   └── README.md
├── lang
│   ├── en
│   │   ├── alert.json
│   │   ├── app.json
│   │   ├── password.json
│   │   ├── settings.json
│   │   └── validation.json
│   └── fr
│       ├── alert.json
│       ├── app.json
│       ├── password.json
│       ├── settings.json
│       └── validation.json
├── main.py
├── resources
│   ├── assets
│   │   └── images
│   │       └── logo.png
│   └── views
│       ├── console
│       │   ├── app.cre
│       │   ├── auth
│       │   │   ├── login.cre
│       │   │   ├── register.cre
│       │   │   └── settings.cre
│       │   ├── components
│       │   │   └── alert.cre
│       │   ├── dashboard.cre
│       │   ├── includes
│       │   │   ├── debug.cre
│       │   │   ├── footer.cre
│       │   │   └── header.cre
│       │   └── layouts
│       │       ├── main.cre
│       │       └── tools
│       │           ├── calculator.cre
│       │           └── devise.cre
│       ├── desktop
│       └── web
│           ├── index.jinja
│           └── layouts
│               └── main.html
├── routes
│   ├── auth.py
│   └── route.py
├── src
│   ├── application
│   │   ├── configs
│   │   │   ├── settings.json
│   │   │   ├── settings.py
│   │   │   ├── version.py
│   │   │   └── __init__.py
│   │   ├── creator.py
│   │   └── __init__.py
│   ├── builds
│   │   ├── templates
│   │   │   ├── command.template
│   │   │   ├── controllers
│   │   │   │   ├── controller.template
│   │   │   │   ├── model.template
│   │   │   │   └── resource.template
│   │   │   ├── creator.template
│   │   │   ├── env
│   │   │   │   ├── app.template
│   │   │   │   ├── databases
│   │   │   │   │   ├── database.template
│   │   │   │   │   ├── mysql.template
│   │   │   │   │   ├── postgresql.template
│   │   │   │   │   ├── sqlite.template
│   │   │   │   │   └── sqlserver.template
│   │   │   │   └── session.template
│   │   │   ├── middleware.template
│   │   │   ├── migration.template
│   │   │   ├── model.template
│   │   │   ├── readme.template
│   │   │   ├── seed.template
│   │   │   ├── trash
│   │   │   │   ├── routes.py
│   │   │   │   └── views.py
│   │   │   ├── views
│   │   │   │   ├── app.template
│   │   │   │   ├── auth.template
│   │   │   │   ├── default.template
│   │   │   │   ├── main.template
│   │   │   │   └── resources
│   │   │   │       ├── create.template
│   │   │   │       ├── edit.template
│   │   │   │       ├── index.template
│   │   │   │       └── view.template
│   │   │   └── __init__.py
│   │   └── __init__.py
│   ├── commands
│   │   ├── delete.py
│   │   ├── install.py
│   │   ├── make.py
│   │   ├── migrate.py
│   │   ├── publish.py
│   │   ├── seed.py
│   │   ├── server.py
│   │   ├── settings.py
│   │   ├── uninstall.py
│   │   ├── venv.py
│   │   └── __init__.py
│   ├── console
│   │   ├── colors.py
│   │   ├── formats.py
│   │   ├── icons.py
│   │   ├── terminal.py
│   │   └── __init__.py
│   ├── controllers
│   │   ├── auth
│   │   │   ├── LoginController.py
│   │   │   └── RegisterController.py
│   │   ├── controller.py
│   │   └── __init__.py
│   ├── core
│   │   ├── collection.py
│   │   ├── crypt.py
│   │   ├── data.py
│   │   ├── date.py
│   │   ├── debug.py
│   │   ├── dict.py
│   │   ├── exception.py
│   │   ├── file.py
│   │   ├── handler.py
│   │   ├── hash.py
│   │   ├── http.py
│   │   ├── injector.py
│   │   ├── interface.py
│   │   ├── lang.py
│   │   ├── list.py
│   │   ├── path.py
│   │   ├── request.py
│   │   ├── responses.py
│   │   ├── route.py
│   │   ├── sessions.py
│   │   ├── speaker.py
│   │   ├── storage.py
│   │   ├── string.py
│   │   ├── task.py
│   │   ├── test.py
│   │   ├── translator.py
│   │   ├── view.py
│   │   └── __init__.py
│   ├── databases
│   │   ├── connections
│   │   │   ├── connector.py
│   │   │   ├── mogo_db.py
│   │   │   ├── mysql_db.py
│   │   │   ├── posgreSQL.py
│   │   │   ├── sqlite.py
│   │   │   └── __init__.py
│   │   ├── database.py
│   │   ├── migration.py
│   │   ├── relation.py
│   │   ├── schema
│   │   │   ├── column.py
│   │   │   ├── table.py
│   │   │   └── __init__.py
│   │   └── seeder.py
│   ├── environment
│   │   └── __init__.py
│   ├── kits
│   │   └── auth
│   ├── middlewares
│   │   ├── auth.py
│   │   ├── log.py
│   │   ├── middleware.py
│   │   └── __init__.py
│   ├── models
│   │   ├── auth.py
│   │   ├── collections
│   │   │   ├── array.py
│   │   │   ├── collections.py
│   │   │   └── list.py
│   │   ├── drivers
│   │   │   ├── database.py
│   │   │   ├── file.py
│   │   │   └── __init__.py
│   │   ├── model.py
│   │   └── __init__.py
│   ├── servers
│   │   ├── basic-server.py
│   │   ├── flask.py
│   │   ├── sever.py
│   │   ├── utils.py
│   │   └── __init__.py
│   └── validators
│       ├── password.py
│       ├── rules.py
│       ├── validator.py
│       └── __init__.py
├── storage
│   ├── sessions
│   │   └── creator.json
│   └── versions
│       ├── creator_0.2.1-beta.zip
│       └── creator_0.2.2-beta.zip
└── tests
    ├── camera.py
    ├── core.py
    ├── cwar.py
    ├── devine.py
    ├── devise.py
    ├── index.html
    ├── interfaces
    │   ├── console
    │   ├── desktop
    │   ├── mobile
    │   └── web
    ├── terminal.py
    ├── test.py
    └── __init__.py
