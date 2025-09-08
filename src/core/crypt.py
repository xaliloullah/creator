class Crypt: 
    try:
        import base64
        from cryptography.fernet import Fernet 
        import hashlib
    except:
        base64 = None
        Fernet = None
        hashlib = None

    from src.environment import env
    app_key:str = env("APP_KEY") 
    if not app_key:
        raise ValueError("APP_KEY") 
    digest = hashlib.sha256(app_key.encode()).digest()
    key = base64.urlsafe_b64encode(digest)
    fernet = Fernet(key)

    @classmethod
    def encrypt(cls, data: str) -> str:
        return cls.fernet.encrypt(data.encode()).decode()

    @classmethod
    def decrypt(cls, token: str) -> str:
        return cls.fernet.decrypt(token.encode()).decode()

 