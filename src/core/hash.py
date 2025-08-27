try: 
    import bcrypt
except:
    pass

try: 
    import hashlib
    import secrets
    import base64 
except:
    pass

class Hash: 
    
    @staticmethod
    def make(password: str, rounds=12) -> str:  
        password_bytes = password.encode('utf-8') 
        salt = bcrypt.gensalt(rounds=rounds) 
        hashed_password = bcrypt.hashpw(password_bytes, salt) 
        return hashed_password.decode('utf-8')
    
    @staticmethod
    def check(password: str, hashed_password: str) -> bool:  
        password_bytes = password.encode('utf-8')
        hashed_password_bytes = hashed_password.encode('utf-8') 
        return bcrypt.checkpw(password_bytes, hashed_password_bytes)
    
    @staticmethod
    def get_salt(hashed_password: str) -> str: 
        return hashed_password[:29] 
    
    @staticmethod
    def generate_random_password(length=16) -> str: 
        characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+'
        return ''.join(secrets.choice(characters) for _ in range(length))
    
    @staticmethod
    def hash_with_custom_salt(password: str, salt: str) -> str: 
        password_bytes = password.encode('utf-8')
        salt_bytes = salt.encode('utf-8') 
        hashed_password = bcrypt.hashpw(password_bytes, salt_bytes)

        # Retourner le mot de passe haché
        return hashed_password.decode('utf-8')
    
    @staticmethod
    def compare_hashes(hash1: str, hash2: str) -> bool: 
        return hash1 == hash2
    
    @staticmethod
    def decode_salt(hashed_password: str) -> str: 
        salt = Hash.get_salt(hashed_password)
        return base64.b64encode(salt.encode('utf-8')).decode('utf-8')

 
class Hash2:    
    @staticmethod
    def __init__(self, algorithm="sha3_256"):
        """
        Initialise une instance avec un algorithme de hachage.
        """
        self.algorithm = algorithm.lower()

    def method(self):
        """Retourne la méthode de hachage associée à l'algorithme."""
        return getattr(hashlib, self.algorithm, None)
    
    @staticmethod
    def generate_salt(length=16):
        """Génère un sel cryptographique."""
        return secrets.token_bytes(length)
    
    @staticmethod
    def hash(self, password):
        """
        Hache un mot de passe avec un sel.
        Retourne le hachage au format "salt:hashed_password".
        """
        if isinstance(password, str):
            password = password.encode('utf-8')
 
        salt = self.generate_salt()
 
        hash_method = self.method()
        if hash_method:
            hash_object = hash_method()
            hash_object.update(salt + password) 
            return f"{salt.hex()}:{hash_object.hexdigest()}"
        else:
            raise ValueError(f"Algorithm '{self.algorithm}' not supported.")
    
    @staticmethod
    def verify(self, password, stored_hash):
        """
        Vérifie si un mot de passe correspond au hachage stocké.
        """
        try: 
            salt_hex, hashed_password = stored_hash.split(":")
            salt = bytes.fromhex(salt_hex)

            if isinstance(password, str):
                password = password.encode('utf-8')
 
            hash_method = self.method()
            if hash_method:
                hash_object = hash_method()
                hash_object.update(salt + password) 
                return hash_object.hexdigest() == hashed_password
            else:
                raise ValueError(f"Algorithm '{self.algorithm}' not supported.")
        except Exception as e: 
            print(f"Erreur : {e}")
            return False