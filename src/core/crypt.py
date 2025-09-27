from config import app
from typing import Any
import json
try:
    import base64
    import hashlib
    from cryptography.fernet import Fernet
except ImportError as e:
    # print(e)
    # error =  RuntimeError(f"{e}")
    pass

class Crypt: 
    try: 
        if not hasattr(app, 'key') or not isinstance(app.key, str) or len(app.key) < 32:
            raise ValueError("app.key")
         
        digest = hashlib.sha256(app.key.encode()).digest()
        key = base64.urlsafe_b64encode(digest)
        fernet = Fernet(key)
    except Exception as e:
        key = None

    @classmethod
    def encrypt(cls, data: Any) -> str: 
        try:
            json_data = json.dumps(data)
            token = cls.fernet.encrypt(json_data.encode())
            return token.decode()
        except Exception as e:
            raise ValueError(f"{e}")

    @classmethod
    def decrypt(cls, token: str) -> Any: 
        try:
            decrypted = cls.fernet.decrypt(token.encode())
            return json.loads(decrypted.decode()) 
        except Exception as e:
            raise ValueError(f"{e}")

    @classmethod
    def is_encrypted(cls, token: str) -> bool: 
        try:
            cls.decrypt(token)
            return True
        except ValueError:
            return False
