from config import database
from src.core import File, Path, Date, Task
from src.builds import Build
from src.console import Terminal 


class Migration:
    path = database.migrations['path']
    table = database.migrations['name']
    file = File(path) 

    def __init__(self, name=None):
        self.name = name

    def create(self):
        try: 
            _timestamp = Date.now().to_string("%Y_%m_%d")
            self.file.path.join(f"{_timestamp}_create_{self.name}_table.py")
            self.file.save(Build.migration(self.name))
            Terminal.success(f"Migration {self.file.name} created successfully.")
        except Exception as e:
            Terminal.error(f"{e}") 
            exit(1)
            
    @classmethod
    def run(cls, name, action='up'): 
        try:
            path = Path(cls.path).join(name)
            Task.run(path, functions=[action]) 
        except Exception as e:
            Terminal.error(f"{e}") 
            exit(1)

    @classmethod
    def get(cls):
        try:
            migrations = cls.file.list(endswith=".py")       
            return sorted(migrations)
        except Exception as e: 
            Terminal.error(f"{e}") 
            exit(1)
    
    @classmethod
    def get_last_batch(cls): 
        from src.databases.query import Query
        result = Query().select(cls.table, 'batch').last().fetchone()
        if result is not None:
            return result['batch']
        else: 
            return 0
    
    @classmethod
    def migrate(cls, run='up'):
        # cls.up()  
        from src.databases.query import Query
        alert = {}
        try:
            if run == 'up':
                cls.up()  
                applied_migrations = cls.check()  
                migrations = cls.get()
                if migrations is not None: 
                    migrations
                    batch = cls.get_last_batch()+1
                for migration in migrations:
                    if migration not in applied_migrations:  
                        cls.run(migration, "up")  
                        Terminal.success(f"Applying migration '{migration}'.") 
                        Query().insert(cls.table, migration=migration,batch=batch).execute() 
                        # alert = {'info': 'Migrations applied successfully.'}
                    else:
                        alert = {'warning': 'Nothing to migrate...'}
            elif run == 'down':  
                applied_migrations = cls.check()
                migrations = cls.get()
                if migrations is not None:
                    migrations.sort(reverse=True)
                    batch = cls.get_last_batch()
                for migration in migrations:
                    if migration in applied_migrations: 
                        if Query().select(cls.table).where(batch=batch).fetchone(): 
                            cls.run(migration, "down")   
                            Terminal.warning(f"Rollback of migration '{migration}'.")
                            Query().delete(cls.table).where(migration=migration, batch=batch).execute()  
                            # alert = {'info': 'Rollback of migrations executed successfully.'} 
                    else:
                        alert = {'error': 'Migrations was not applied; cannot rollback.'}
            if alert:
                for type, message in alert.items():
                    if type == 'success':
                        Terminal.success(message)
                    elif type == 'warning':
                        Terminal.warning(message)
                    elif type == 'error':
                        Terminal.error(message)
                    elif type == 'info':
                        Terminal.info(message)
                    else:
                        Terminal.error(f"Unknown message type: {type}, Message: {message}")

        except Exception as e:
            Terminal.error(f"{e}") 
            exit(1)

    @classmethod
    def drop_all(cls):
        Terminal.info("Droping all tables")
        # from src.databases.query import Query
        # tables = Query().select(cls.table, 'migration').fetchall()  
        # # for table in tables:
        # #     Query().drop(table)

        
    @classmethod
    def check(cls): 
        from src.databases.query import Query 
        results = Query().select(cls.table, 'migration').fetchall() 
        migrations = cls.get()
        applied_migrations = []
        for result in results: 
            if result['migration'] in migrations:
                applied_migrations.append(result['migration'])     
        return applied_migrations


    @classmethod
    def up(cls):
        from src.databases.schema.table import Table 
        table = Table(cls.table) 
        table.column.id()
        table.column.string('migration').unique().not_null()
        table.column.tinyint('batch').default(1) 
        table.create()

    @classmethod
    def down(cls):
        from src.databases.schema.table import Table 
        table = Table(cls.table)
        table.drop()
