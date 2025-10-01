class Provider:

    # Commands
    from src.commands.make import MakeCommand
    from src.commands.delete import DeleteCommand
    from src.commands.install import InstallCommand
    from src.commands.uninstall import UninstallCommand
    from src.commands.migrate import MigrateCommand
    from src.commands.venv import VenvCommand 
    from src.commands.seed import SeedCommand
    from src.commands.server import ServerCommand
    from src.commands.publish import PublishCommand
    from src.commands.route import RouteCommand
    from src.commands.test import TestCommand
    from src.commands.setting import SettingCommand

    commands = [
        MakeCommand, DeleteCommand, InstallCommand, UninstallCommand, MigrateCommand, VenvCommand, SeedCommand, ServerCommand, RouteCommand, TestCommand, SettingCommand
        ]
    

    # Middlewares

    from app.middlewares.app import AppMiddleware 
    from app.middlewares.auth import AuthMiddleware  

    middlewares = {
        "app": AppMiddleware,
        "auth": AuthMiddleware
    }

    events = []

