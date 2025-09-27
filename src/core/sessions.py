from typing import Any
from src.core import Structure
from src.core import Path, Date
from config import session 

class Session(Structure):

    def __init__(self):  
        self.path = Path.session(session.name)
        super().__init__(self.path)

    def put(self, key, value): 
        self.set(key, value)

    def is_active(self):
        return not self.is_expired()

    def is_expired(self):
        if self.get("expires_at"):
            if Date.now() > Date.parse(self.get("expires_at")):
                return True
        return False

    def flash(self, status, message):  
        messages = self.get(f"flash.{status}", default=[])
        if not isinstance(messages, list):
            messages = []
        if isinstance(message, (tuple, list)):
            messages.extend(message)
        else:
            messages.append(message)
        self.put(f"flash.{status}", messages)

    def get_flash(self, status=None):
        if status:
            flash = self.get(f"flash.{status}", [])
            self.put(f"flash.{status}", None)
        else: 
            flash = self.get("flash", {})
            self.put("flash", {}) 
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

    def forget(self, key: str): 
        self.put(key, None)

    def token(self):
        import uuid
        if not self.has('_token'):
            self.put('_token',str(uuid.uuid4()))
        return self.get('_token')
 
    def create(self, user_id: str|Any=None, remember_me: bool=False): 
        return super().create(
            user_id= user_id, 
            expires_at = str(Date.now().add_minutes(int(session.lifetime)).timestamp()),
            last_activity = str(Date.now().timestamp()),
            remember_me= remember_me
        ) 
    
    def update(self, **kwargs):
        if 'last_activity' not in kwargs:
            kwargs['last_activity'] = f"{Date.now().timestamp()}"
        return super().update(**kwargs)
     
    def flush(self):
        self.destroy() 
        