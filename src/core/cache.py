import time


class Cache:
    def __init__(self): 
        self.data = {}

    def set(self, key, value, ttl=None): 
        expire_at = time.time() + ttl if ttl else None
        self.data[key] = (value, expire_at)

    def get(self, key, default=None): 
        if key not in self.data:
            return default

        value, expire_at = self.data[key]
        if expire_at and time.time() > expire_at:  # expiré
            del self.data[key]
            return default
        return value

    def delete(self, key): 
        if key in self.data:
            del self.data[key]

    def clear(self): 
        self.data.clear()

    def has(self, key): 
        return self.get(key) is not None
