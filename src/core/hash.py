class Hash:  
    
    @classmethod 
    def generate_key(cls, length=42):
        import secrets
        return secrets.token_urlsafe(length)

    @classmethod
    def make(cls, password: str, rounds=12) -> str:
        import bcrypt 
        salt = bcrypt.gensalt(rounds=rounds) 
        hashed = bcrypt.hashpw(password.encode('utf-8'), salt) 
        return hashed.decode('utf-8')
    
    @classmethod
    def check(cls, password: str, hashed: str) -> bool:
        import bcrypt 
        return bcrypt.checkpw(password.encode('utf-8'), hashed.encode('utf-8'))
    
    @classmethod
    def get_salt(cls, hashed: str) -> str: 
        return hashed[:29] 
    
    @classmethod
    def generate_random_password(cls, length=16) -> str: 
        import secrets
        characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+'
        return ''.join(secrets.choice(characters) for _ in range(length))
    
    @classmethod
    def hash_with_custom_salt(cls, password: str, salt: str) -> str: 
        import bcrypt 
        password_bytes = password.encode('utf-8')
        salt_bytes = salt.encode('utf-8') 
        hashed = bcrypt.hashpw(password_bytes, salt_bytes)
        return hashed.decode('utf-8')
    
    @classmethod
    def compare_hashes(cls, hash1: str, hash2: str) -> bool: 
        return hash1 == hash2
    
    @classmethod
    def decode_salt(cls,  hashed: str) -> str: 
        import base64
        salt = Hash.get_salt(hashed)
        return base64.b64encode(salt.encode('utf-8')).decode('utf-8')
    
    @staticmethod
    def generate_salt(length=16): 
        import secrets
        return secrets.token_bytes(length)
      
    def __init__(self, algorithm="sha3_256"):
        import hashlib
        # algos_classiques = [
        #     "md5",
        #     "sha1",
        #     "sha224",
        #     "sha256",
        #     "sha384",
        #     "sha512",
        #     "sha3_224",
        #     "sha3_256",
        #     "sha3_384",
        #     "sha3_512",
        #     "blake2b",
        #     "blake2s"
        # ]
        self.algorithm = algorithm.lower()
        if not hasattr(hashlib, self.algorithm):
            raise ValueError(f"Algorithm '{self.algorithm}' not supported.")

    def hash(self, password):
        import hashlib
        if isinstance(password, str):
            password = password.encode('utf-8')
        salt = self.generate_salt()
        hash_object = getattr(hashlib, self.algorithm)()
        hash_object.update(salt + password)
        return f"{salt.hex()}:{hash_object.hexdigest()}"

    def verify(self, password, stored_hash):
        try:
            import hashlib
            salt_hex, hashed = stored_hash.split(":")
            salt = bytes.fromhex(salt_hex)
            if isinstance(password, str):
                password = password.encode('utf-8')
            hash_object = getattr(hashlib, self.algorithm)()
            hash_object.update(salt + password)
            return hash_object.hexdigest() == hashed
        except Exception as e:
            print(e)
            return False 