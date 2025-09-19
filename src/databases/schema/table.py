from src.databases.query import Query
from src.databases.schema import Column 

class Table:

    def __init__(self, name):
        self.name = name 
        self.column = Column(self.name)
        
    def create(self, if_not_exists=True, engine="InnoDB", charset="utf8mb4"):  
        Query().create(self.name, self.column.generate()).execute()
    
    def update(self):
        for definition in self.column.generate(command=True):
            Query().alter(self.name, definition).execute() 

    def drop(self): 
        Query().drop(self.name).execute() 

    # def truncate(self):
    #     Query().truncate(self.name).execute()

    # def rename(self, name):
    #     Query().rename(self.name, name).execute()
    #     self.name = name

