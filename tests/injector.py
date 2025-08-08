import sys
import os
 
sys.path.append(os.path.abspath(os.path.join(__file__, "..", "..")))

from src.core import Injector

class Database:
    def connect(self):
        print("Connected to DB")

class Logger:
    def log(self, msg):
        print("LOG:", msg)

injector = Injector()

# Enregistrement avec des noms
injector.register(Database)
injector.register(Logger, Logger())

# Fonction utilisant les annotations par nom
def process_data(db: Database, logger: Logger):
    db.connect()
    logger.log("Processing data...")

injector.resolve(process_data)
