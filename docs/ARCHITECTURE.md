├── .env
├── .gitignore
├── app
│   ├── controllers
│   │   ├── games
│   │   │   ├── CwarController.py
│   │   │   └── DevineController.py
│   │   ├── RouteController.py
│   │   ├── TestController.py
│   │   └── tools
│   │       ├── CalculatorController.py
│   │       └── DeviseController.py
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
│       │   ├── cwar.py
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
│   └── ARCHITECTURE.md
├── lang
│   └── en
│       ├── alert.json
│       ├── app.json
│       ├── password.json
│       ├── settings.json
│       └── validation.json
├── main.py
├── README.md
├── requirements.json
├── resources
│   ├── assets
│   ├── interfaces
│   │   ├── console
│   │   ├── desktop
│   │   └── web
│   └── views
│       ├── app.cre
│       ├── auth
│       │   ├── login.cre
│       │   └── register.cre
│       ├── components
│       │   └── alert.cre
│       ├── includes
│       │   ├── debug.cre
│       │   ├── footer.cre
│       │   └── header.cre
│       └── layouts
│           ├── games
│           │   ├── cwar
│           │   │   ├── edit.cre
│           │   │   ├── main.cre
│           │   │   ├── menu.cre
│           │   │   └── view.cre
│           │   └── devine
│           │       ├── create.cre
│           │       ├── edit.cre
│           │       ├── index.cre
│           │       └── view.cre
│           ├── main.cre
│           ├── tests
│           │   ├── create.cre
│           │   ├── edit.cre
│           │   ├── index.cre
│           │   └── view.cre
│           └── tools
│               ├── calculator.cre
│               └── devise.cre
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
│   │   ├── contexts
│   │   │   ├── handler.py
│   │   │   ├── request.py
│   │   │   ├── responses.py
│   │   │   ├── sessions.py
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
│   │   ├── lang.py
│   │   ├── make.py
│   │   ├── migrate.py
│   │   ├── publish.py
│   │   ├── seed.py
│   │   ├── server.py
│   │   ├── Setting.py
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
│   │   ├── exception.py
│   │   ├── file.py
│   │   ├── hash.py
│   │   ├── http.py
│   │   ├── injector.py
│   │   ├── interface.py
│   │   ├── lang.py
│   │   ├── path.py
│   │   ├── route.py
│   │   ├── storage.py
│   │   ├── task.py
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
│   │   ├── query.py
│   │   ├── relation.py
│   │   ├── schema
│   │   │   ├── column.py
│   │   │   ├── table.py
│   │   │   └── __init__.py
│   │   └── seeder.py
│   ├── environment
│   │   └── __init__.py
│   ├── middlewares
│   │   ├── auth.py
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
│   └── validators
│       ├── password.py
│       ├── rules.py
│       ├── validator.py
│       └── __init__.py
├── storage
│   ├── games
│   │   └── cwar.json
│   ├── sessions
│   │   └── creator.json
│   ├── tools
│   │   ├── calculator.json
│   │   └── devise.json
│   └── versions
│       └── creator_0.1.56-beta.zip
└── tests
    ├── cwar.py
    ├── data.py
    ├── devine.py
    ├── devise.py
    ├── hash.py
    ├── injector.py
    ├── route.py
    ├── session.py
    ├── storage.py
    ├── terminal.py
    ├── validation.py
    ├── views.py
    └── __init__.py
