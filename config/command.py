from src.commands import Command 

from src.commands.make import MakeCommand
from src.commands.delete import DeleteCommand
from src.commands.install import InstallCommand
from src.commands.uninstall import UninstallCommand
from src.commands.migrate import MigrateCommand
from src.commands.venv import VenvCommand 
from src.commands.seed import SeedCommand
from src.commands.server import ServerCommand
from src.commands.publish import PublishCommand
from src.commands.setting import SettingCommand

Command.add(
    MakeCommand, 
    DeleteCommand, 
    InstallCommand, 
    UninstallCommand, 
    MigrateCommand, 
    VenvCommand, 
    SeedCommand, 
    ServerCommand, 
    PublishCommand, 
    SettingCommand
) 