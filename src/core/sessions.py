# import uuid
from config import session 
from src.core import Date, Collection, Storage

class Session:  
    
    def __init__(self, **kwargs) -> None: 
        self.path = session.path
        self.driver = kwargs.get("driver", session.driver)
        self.data = self.load() 

    def get(self, key:str, default=None):
        return self.data.get(key, default)  
    
    def set(self, key:str, value):
        self.data.set(key, value)
    
    def load(self, **kwargs):
        try:    
            if session.driver == 'file': 
                self.file = Storage(self.path, format="json", default={}, absolute=True)
                return Collection(self.file.read())
        except Exception as e:
            raise Exception(e)
          
    def save(self, **kwargs):  
        if session.driver == 'file':
            backup = self.load()
            try:    
                self.file.save(self.data.get()) 
            except Exception as e:
                self.file.save(backup.get())  
                raise Exception(e) 


    def create(self, user_id=None):    
        # self.set(f"id", self.id)
        self.set(f"user_id", user_id) 
        self.set(f"expires_at", f"{Date.add_minutes(Date.now(), int(session.lifetime))}") 
        self.set(f"last_activity", f"{Date.now()}") 
        self.save() 
        
    def update(self):  
        self.set(f"last_activity", f"{Date.now()}") 
        self.save()
        
    def is_active(self):
        if self.get("expires_at"):
            if Date.now() < Date.strtotime(self.get("expires_at")):
                return True 
        return False
    
    def flash(self, status, message):  
        messages = self.get(f"flash.{status}", default=[])  
        if isinstance(message, (tuple, list)):
            messages.extend(message)
        else:
            messages.append(message)
        
        self.set(f"flash.{status}", messages) 
        self.update()

    def get_flash(self, status=None):
        if status:
            flash = self.get(f"flash.{status}", [])
            self.set(f"flash.{status}", [])
        else: 
            flash = self.get("flash", {})
            self.set("flash", {})
        self.update()
        return flash
     
    def error(self, *message):
        self.flash("error", message) 
          
    def success(self, *message):
        self.flash("success", message) 
        
    def has(self, key: str):
        return bool(self.get(key)) 
    
    def has_errors(self):
        return self.has("flash.error")
    
    def has_success(self):
        return self.has("flash.success")
    
    def get_errors(self):
        return self.get_flash("error")
    
    def get_success(self):
        return self.get_flash("success") 
    
    def destroy(self): 
        try:
            self.data = Collection({})   
            if session.driver == 'file':
                self.file.save({})  
        except Exception as e:
            raise Exception(e)
