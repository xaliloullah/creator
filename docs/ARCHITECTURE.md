├── .env
├── .gitignore
├── app
│   ├── controllers
│   │   ├── auth
│   │   │   ├── LoginController.py
│   │   │   └── RegisterController.py
│   │   ├── RouteController.py
│   │   └── UserController.py
│   ├── middlewares
│   │   ├── app.py
│   │   └── auth.py
│   └── models
│       └── auth
│           ├── auth.py
│           └── user.py
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
│   └── en
│       ├── alert.json
│       ├── app.json
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
│       │   │   └── register.cre
│       │   ├── components
│       │   │   └── alert.cre
│       │   ├── dashboard.cre
│       │   ├── includes
│       │   │   ├── footer.cre
│       │   │   └── header.cre
│       │   └── layouts
│       │       └── main.cre
│       ├── desktop
│       └── web
├── routes
│   ├── auth.py
│   └── route.py
├── settings.json
├── src
│   ├── application
│   │   ├── configs
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
│   │   │   ├── models
│   │   │   │   ├── model.template
│   │   │   │   └── structure.template
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
│   │   ├── setting.py
│   │   ├── uninstall.py
│   │   ├── venv.py
│   │   └── __init__.py
│   ├── console
│   │   ├── colors.py
│   │   ├── formats.py
│   │   ├── icons.py
│   │   ├── terminal.py
│   │   └── __init__.py
│   ├── core
│   │   ├── cache.py
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
│   │   ├── structure.py
│   │   ├── task.py
│   │   ├── test.py
│   │   ├── translator.py
│   │   ├── view.py
│   │   └── __init__.py
│   ├── databases
│   │   ├── connections
│   │   │   ├── builder.py
│   │   │   ├── connector.py
│   │   │   ├── mysql_db.py
│   │   │   ├── postgresql_db.py
│   │   │   ├── sqlite.py
│   │   │   └── __init__.py
│   │   ├── database.py
│   │   ├── migration.py
│   │   ├── model.py
│   │   ├── query.py
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
│   │   ├── middleware.py
│   │   └── __init__.py
│   ├── servers
│   │   ├── basic-server.py
│   │   ├── sever.py
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
│       └── creator_0.2.30.zip
└── tests
    ├── camera.py
    ├── core.py
    ├── devine.py
    ├── devise.py
    ├── model.py
    ├── terminal.py
    ├── test.py
    └── __init__.py
