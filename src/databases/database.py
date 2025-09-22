class Database:
    from config import database 
    def __init__(self, engine=database.driver):
        from src.databases.connections import Connector
        self.connection = Connector.connect(engine)

    def execute(self, query, params=None):
        if not params: 
            return self.connection.execute(query)
        return self.connection.execute(query, params) 

    def commit(self):
        self.connection.commit()

    def rollback(self):
        self.connection.rollback()

    def fetchall(self, query, params=None):
        self.execute(query, params)
        rows = self.connection.fetchall() 
        return [dict(row) for row in rows] if rows else []

    def fetchone(self, query, params=None):
        self.execute(query, params)
        row = self.connection.fetchone()
        return dict(row) if row else None

    def close(self):
        self.connection.close() 

    from contextlib import contextmanager
    @contextmanager
    def transaction(self):
        try:
            yield
            self.commit()
        except Exception:
            self.rollback()
            raise
