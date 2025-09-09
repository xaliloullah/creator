from src.databases.query import Query
from src.databases.schema import Column 

class Table(Column):
    def __init__(self, name):
        super().__init__()
        self.name = name 
        
    def __str__(self):
        return self.get_definition()

    def generate_script(self, multiline=False):
        sep = ",\n" if multiline else ", "
        return sep.join(self.definition + self.foreign_keys)

    def get_definition(self):
        return self.generate_script(multiline=False)

    def get_script(self):
        return self.generate_script(multiline=True)

    
    def create(self , if_not_exists=True, engine="InnoDB", charset="utf8mb4"):  
        Query().create(self.name, self.get_definition(), if_not_exists=True, engine="InnoDB", charset="utf8mb4").execute()

    def drop(self): 
        Query().drop(self.name).execute() 