from config import database

class Connector: 
    driver = database.driver 
    @classmethod
    def database(cls, driver:str=driver): 
        
        # Dynamically import the corresponding Database
        if driver == 'sqlite':  
            from .sqlite_db import Sqlite
            return Sqlite
        elif driver == 'mysql':
            from .mysql_db import MySQL
            return MySQL 
        elif driver == 'postgresql':
            from .postgresql_db import PostgreSQL
            return PostgreSQL
        elif driver == 'sqlserver':
            from .sqlserver_db import SQLServer
            return SQLServer
        elif driver == 'oracle':
            from .oracle_db import Oracle
            return Oracle 
        else:
            raise Exception(f"Unsupported database driver: {driver}")
        
    @classmethod
    def connect(cls, driver:str=driver): 
        # Fetch connection configuration for the driver
        connections = database.connections
        if driver not in connections:
            raise Exception(f"No connection configuration found for driver: {driver}")
        config = connections[driver]
        # Return an instance of the database class
        db = Connector.database(driver)
        return db(config)
