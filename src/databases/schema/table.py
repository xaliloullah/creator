from src.databases.query import Query
from src.databases.schema import Column 

class Table:

    def __init__(self, name):
        self.name = name 
        self.column = Column(self.name)

    def insert(self, **kwargs):
        Query().insert(self.name, **kwargs).execute()

        
    def create(self, if_not_exists=True):  
        # , engine="InnoDB", charset="utf8mb4"
        Query().create(self.name, self.column.generate(), if_not_exists).execute()
    
    def update(self):
        for definition in self.column.generate(command=True):
            Query().alter(self.name, definition).execute() 

    def drop(self, if_exists=True): 
        Query().drop(self.name, if_exists).execute()

    # def truncate(self):
    #     Query().truncate(self.name).execute()

    # def rename(self, name):
    #     Query().rename(self.name, name).execute()
    #     self.name = name

