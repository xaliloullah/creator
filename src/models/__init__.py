from .model import Model
# from src.databases.query import DB  
# from src.models.drivers import DatabaseDriver, FileDriver

# class Model:
#     def __init__(self, table, driver="database", id=""): 
#         self.table = table
#         self.id = id
#         self.DB = DB()
#         # self.attributes = self.all().get() 
#         if driver == "database":
#             return DatabaseDriver(table)
#         elif driver == "file":
#             return FileDriver(table)
#         else:
#             raise ValueError("Driver inconnu")

#     def __str__(self):
#         return str(self.get())
    
#     def __getattr__(self, name):
#         return self.get().get(name)
     
#     def __getitem__(self, index): 
#         return self.get()[index]
    
#     def __iter__(self): 
#         return iter(self.get())
    
#     def __len__(self):
#         return len(self.get())
    
#     def __repr__(self):
#         return str(self.get())

#     def new(self, columns):
#         self.DB.create(self.table, columns).execute()
#         return self
    
#     def create(self, **column):
#         self.DB.insert(self.table, **column).execute()

#     def update(self, **kwargs):
#         self.DB.update(self.table, **kwargs).where(id=self.get_id()).execute()

#     def delete(self): 
#         self.DB.delete(self.table).where(id=self.get_id()).execute()

#     def drop(self):
#         self.DB.drop(self.table).execute()
        
#     def all(self):
#         self.attributes = self.DB.select(self.table).fetchall()
#         return self

#     def find(self, id):
#         self.id = id
#         self.attributes = self.DB.select(self.table).where(id=id).fetchone()
#         return self     

#     def where(self, **kwargs): 
#         self.attributes = self.DB.select(self.table).where(**kwargs).fetchall()
#         return self

#     def where_not(self, **kwargs):
#         self.attributes = self.DB.select(self.table).where_not(**kwargs).fetchall()
#         return self

#     def or_where(self, **kwargs):
#         self.attributes = self.DB.select(self.table).or_where(**kwargs).fetchall()
#         return self

#     def like(self, **kwargs):
#         self.attributes = self.DB.select(self.table).like(**kwargs).fetchall()
#         return self

#     def take(self, value:int):
#         self.attributes = self.DB.select(self.table).limit(value).fetchall()
#         return self

#     def order_by(self, column='id'):
#         self.attributes = self.DB.select(self.table).order_by(column).fetchall()
#         return self

#     def order_by_desc(self, column='id'):
#         self.attributes = self.DB.select(self.table).order_by(column,"DESC").fetchall()
#         return self

#     def count(self): 
#         return self.DB.count(self.table)
    
#     def first(self):  
#         return self.DB.first().fetchone()   
    
#     def last(self):  
#         return self.DB.last().fetchone()
    
#     def get_id(self):
#         return self.id

#     def get(self):
#         return self.attributes