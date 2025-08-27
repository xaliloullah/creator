from src.core import Storage, Collection

class FileDriver:
    def __init__(self, path=None, format="json", default=None, absolute=True):
        self.storage = Storage(path=path, format=format, default=default, absolute=absolute)
        data = self.storage.read() or default or []
        self._data = Collection(*data) 

    # Persist changes
    def execute(self):
        self.storage.save(list(self._data))

    # Fetch
    def fetchall(self):
        return self._data

    def fetchone(self):
        return self._data.first()

    # CRUD
    def create(self, table, columns=None):
        self._data = Collection() 
        return self

    def drop(self, table):
        self.storage.delete()
        self._data = Collection() 
        return self

    def insert(self, table, **kwargs):
        self._data.add(kwargs) 
        return self

    def update(self, table, **kwargs):
        for row in self._data:
            if isinstance(row, dict):
                row.update(kwargs)
        return self

    def delete(self, table):
        for row in self._data:
            self._data.remove(row) 
        return self

    def select(self, table, *columns):
        if not columns or "*" in columns:
            self._data = self._data
        else:
            self._data = Collection(
                {col: row.get(col) for col in columns} for row in self._data
            )
        return self

    # Filtering
    def where(self, **kwargs):
        self._data = self._data.where(**kwargs)
        return self

    def like(self, **kwargs):
        self._data = self._data.filter(
            lambda r: all(v.lower() in str(r.get(k, "")).lower() for k, v in kwargs.items())
        )
        return self

    # Helpers
    def count(self, table=None):
        return self._data.count()

    def first(self):
        self._data = self._data.first()
        return self

    def last(self):
        self._data = Collection(self._data.last())
        return self

    def __call__(self):
        return self.fetchall()
