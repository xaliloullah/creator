from src.models.drivers import DatabaseDriver, FileDriver


class Model:
    def __init__(self, table, driver="database", id=""):
        self.table = table
        if driver == 'database':
            self.driver = DatabaseDriver()
        else:
            self.driver = FileDriver(self.table)

        self.id = id  
        self.attributes = self.all().get() 

    def new(self, columns):
        self.driver.create(self.table, columns).execute()
        return self
    
    def create(self, **column):
        self.driver.insert(self.table, **column).execute()

    def update(self, **kwargs):
        self.driver.update(self.table, **kwargs).where(id=self.get_id()).execute()

    def delete(self): 
        self.driver.delete(self.table).where(id=self.get_id()).execute()

    def drop(self):
        self.driver.drop(self.table).execute()
        
    def all(self):
        self.attributes = self.driver.select(self.table).fetchall()
        return self

    def find(self, id):
        self.id = id
        self.attributes = self.driver.select(self.table).where(id=id).fetchone()
        return self     

    def where(self, **kwargs): 
        self.attributes = self.driver.select(self.table).where(**kwargs).fetchall()
        return self

    def where_not(self, **kwargs):
        self.attributes = self.driver.select(self.table).where_not(**kwargs).fetchall()
        return self

    def or_where(self, **kwargs):
        self.attributes = self.driver.select(self.table).or_where(**kwargs).fetchall()
        return self

    def like(self, **kwargs):
        self.attributes = self.driver.select(self.table).like(**kwargs).fetchall()
        return self

    def take(self, value:int):
        self.attributes = self.driver.select(self.table).limit(value).fetchall()
        return self

    def order_by(self, column='id'):
        self.attributes = self.driver.select(self.table).order_by(column).fetchall()
        return self

    def order_by_desc(self, column='id'):
        self.attributes = self.driver.select(self.table).order_by(column,"DESC").fetchall()
        return self

    def count(self): 
        return self.driver.count(self.table)
    
    def first(self):  
        return self.driver.first().fetchone()   
    
    def last(self):  
        return self.driver.last().fetchone()
    
    def get_id(self):
        return self.id

    def get(self):
        return self.attributes
    
    def __str__(self):
        return str(self.get())
    
    def __getattr__(self, name):
        return self.get().get(name)
     
    def __getitem__(self, index): 
        return self.get()[index]
    
    def __iter__(self): 
        return iter(self.get())
    
    def __len__(self):
        return len(self.get())
    
    def __repr__(self):
        return str(self.get())
    
    
    

    # def get_schema(self):
    #     return self.driver.get_schema(self.table)

    # def get_methodes(self):
    #     self.methodes = []
    #     for function, membre in self.__class__.__dict__.items():
    #         if callable(membre) and not function.startswith('__'):
    #             self.methodes.append(f" - {function}()")
    #     return self.methodes

    # def get_variables(self):
    #     variables = ""
    #     for key, value in vars(self).items():
    #         if isinstance(value, list):
    #             variables += f"{key}:\n{'\n'.join(map(str, value))}\n\n"
    #         elif isinstance(value, dict):
    #             variables += f"{key}:\n"
    #             variables += '\n'.join([f" {sub_key}: {item}" for sub_key,
    #                                     item in value.items()])
    #         else:
    #             variables += f"{key}: {value}\n\n"
    #     return variables

    # def get_primary_key_value(self):
    #     return self.driver.get_primary_key_value(self.table)
