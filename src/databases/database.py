from src.databases.connections import Connector 

class Database:
    def __init__(self):
        self.connection = Connector.connect()

    def execute(self, query, params=None):
        if not params: 
            return self.connection.execute(query)
        return self.connection.execute(query, params) 

    def commit(self):
        self.connection.connection.commit()

    def rollback(self):
        self.connection.connection.rollback()

    def fetchall(self, query, params=None):
        self.execute(query, params)
        rows = self.connection.cursor.fetchall() 
        return [dict(row) for row in rows] if rows else []

    def fetchone(self, query, params=None):
        self.execute(query, params)
        row = self.connection.cursor.fetchone()
        return dict(row) if row else None

    def close(self):
        self.connection.cursor.close() 

    from contextlib import contextmanager

    @contextmanager
    def transaction(self):
        try:
            yield
            self.commit()
        except Exception:
            self.rollback()
            raise
