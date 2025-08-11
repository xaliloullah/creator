from src.commands import Command 

from src.commands.make import MakeCommand
from src.commands.delete import DeleteCommand
from src.commands.install import InstallCommand
from src.commands.uninstall import UninstallCommand
from src.commands.migrate import MigrateCommand
from src.commands.venv import VenvCommand 
from src.commands.seed import SeedCommand
from src.commands.settings import SettingCommand

Command.add(MakeCommand)
Command.add(DeleteCommand)
Command.add(InstallCommand)
Command.add(UninstallCommand)
Command.add(MigrateCommand)
Command.add(VenvCommand) 
Command.add(SeedCommand) 
Command.add(SettingCommand) 