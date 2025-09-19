from config import database
from src.databases.connections import Sqlite, MySQL, PostgreSQL #, SQLServer, Oracle, MariaDB


sqlite = 'sqlite'
mysql = 'mysql'
postgresql = 'postgresql'
# sqlserver = 'sqlserver'
# oracle = 'oracle'
# mariadb = 'mariadb'

# PROVIDER = {
#     sqlite: Sqlite,
#     mysql: MySQL,
#     postgresql: PostgreSQL,
#     # sqlserver: SQLServer,
#     # oracle: Oracle,
#     # mariadb: MariaDB,
# }

driver = database.driver
connections = database.connections
config = connections[driver]

class Connector:
    driver = database.driver
    
    @staticmethod
    def connect(): 
        if driver == sqlite:
            return Sqlite(config)
        elif driver == mysql: 
            return MySQL(config) 
        elif driver == postgresql:
            return PostgreSQL(config)
        # elif driver == sqlserver:
        #     return SQLServer(config)
        # elif driver == oracle:
        #     return Oracle(config)
        # elif driver == mariadb:
        #     return MariaDB(config)
        else: 
            raise Exception(f"Unsupported database driver: {driver}")
    
    @staticmethod
    def database():
        if driver == sqlite:  
            return Sqlite
        elif driver == mysql:
            return MySQL 
        elif driver == postgresql:
            return PostgreSQL
        else:
            raise Exception(f"The database driver '{driver}' is not supported.")