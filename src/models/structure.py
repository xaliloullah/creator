from src.core import Storage, Date, String
from src.models.collections.collection import Collection
import uuid


class Structure:
    primary_key = "id"
    auto_increment = True
    path = None
    storage: Storage = None
    data: Collection = None
    single = False

    def __init_subclass__(cls, **kwargs):
        super().__init_subclass__(**kwargs) 
        if cls.path is None:
            cls.path = f"{String(cls.__name__.lower()).pluralize()}.json"
        default_value = {} if cls.single else []
        cls.storage = Storage(cls.path, format="json", default=default_value, absolute=False)

    def __init__(self, data):
        self.data = data

    # ------------------------
    # ID Generation
    # ------------------------
    @classmethod
    def generate_id(cls):
        if cls.single:
            return None
        if cls.auto_increment:
            last_record = cls.last()
            if not last_record:
                return 1
            return int(last_record[cls.primary_key]) + 1
        return str(uuid.uuid4())

    # ------------------------
    # CRUD
    # ------------------------
    @classmethod
    def all(cls):
        data = cls.storage.read() or ({} if cls.single else [])
        return cls(Collection(data) if not cls.single else data)

    @classmethod
    def create(cls, **kwargs):
        if cls.single:
            cls.storage.save(kwargs if kwargs else {})
            return cls(kwargs if kwargs else {})

        data = cls.storage.read() or []
        new_id = cls.generate_id()
        kwargs = {cls.primary_key: new_id, **kwargs}
        now = str(Date.now().to_string())
        kwargs["created_at"] = now
        kwargs["updated_at"] = now
        data.append(kwargs)
        cls.storage.save(data)
        return cls(kwargs)

    def update(self, **kwargs):
        if self.single:
            current = self.storage.read() or {}
            current.update(kwargs)
            current["updated_at"] = str(Date.now().to_string())
            self.storage.save(current)
            self.data.update(kwargs)
            return self

        data = self.storage.read() or []
        for i, item in enumerate(data):
            if item.get(self.primary_key) == self.data.get(self.primary_key):
                data[i].update(kwargs)
                data[i]["updated_at"] = str(Date.now().to_string())
                self.data.update(kwargs)
                break
        self.storage.save(data)
        return self

    @classmethod
    def find(cls, id=None):
        if cls.single:
            return cls(cls.storage.read() or {})
        data = cls.storage.read() or []
        for item in data:
            if item.get(cls.primary_key) == id:
                return cls(item)
        return None

    @classmethod
    def where(cls, **kwargs):
        data = cls.all().data
        if cls.single:
            match = all(data.get(k) == v for k, v in kwargs.items())
            return cls(data if match else {})
        filtered = data.where(**kwargs)
        return cls(Collection(filtered))

    def delete(self):
        if self.single:
            self.storage.save({})
            self.data = {}
            return True

        data = self.storage.read() or []
        data = [item for item in data if item.get(self.primary_key) != self.data.get(self.primary_key)]
        self.storage.save(data)
        return True

    # ------------------------
    # Helpers
    # ------------------------
    @classmethod
    def count(cls):
        data = cls.storage.read() or ({} if cls.single else [])
        if cls.single:
            return len(data.keys())
        return len(data)

    @classmethod
    def first(cls):
        data = cls.all().data
        if cls.single:
            return cls(data)
        return cls(data.first())

    @classmethod
    def last(cls):
        data = cls.all().data
        if cls.single:
            return cls(data)
        return cls(data.last())

    def get(self, key: str, default=None):
        keys = key.split(".")
        current = self.data
        for key in keys:
            if isinstance(current, dict) and key in current:
                current = current[key]
            else:
                return default
        return current

    def set(self, key: str, value):
        keys = key.split(".")
        current = self.data
        for k in keys[:-1]:
            if k not in current or not isinstance(current[k], dict):
                current[k] = {}
            current = current[k]
        current[keys[-1]] = value
        self.update(**self.data)
        return self

    # ------------------------
    # Magic methods
    # ------------------------
    def __getattr__(self, key):
        if isinstance(self.data, dict) and key in self.data:
            return self.data[key]
        raise AttributeError(f"{key} not found")

    def __setattr__(self, key, value):
        if key in ("data", "path", "storage", "single"):
            super().__setattr__(key, value)
        else:
            self.data[key] = value
            self.update(**{key: value})

    def __getitem__(self, key):
        try:
            return self.data[key]
        except (KeyError, TypeError):
            raise AttributeError

    def __repr__(self):
        return f"<{self.__class__.__name__} {self.data}>"

    def __str__(self):
        return str(self.data)
    
    def __len__(self):
        return len(self.data)
    
    # def __iter__(self):
    #     if isinstance(self.data, Collection) or isinstance(self.data, list):
    #         return iter(self.data)
    #     elif isinstance(self.data, dict):
    #         return iter([self.data])  
    #     return iter([])
