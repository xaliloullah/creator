class RDBMS:
    """Generic base class for relational database connectors."""

    # Default SQL placeholder (can be overridden in subclasses, e.g., '%s' for psycopg2)
    placeholder:str = '?'
    # SQL syntax
    syntax:dict = {}


    def __init__(self, config: dict):
        """
        Initialize the RDBMS connector.

        Args:
            config (dict): Connection configuration parameters (host, port, user, password, database, etc.)
        """
        self.connection = None
        self.cursor = None 
        self.master = ""

    # ---------- Abstract methods (must be implemented in subclasses) ----------

    # def connect(self):
    #     """Establish the database connection."""
    #     raise NotImplementedError("The 'connect' method must be implemented in the child class.")

    def execute(self, query: str, params: tuple | list | None = None):
        """Execute a SQL query."""
        raise NotImplementedError("The 'execute' method must be implemented in the child class.")

    def fetchall(self):
        """Fetch all rows from the last executed query."""
        raise NotImplementedError("The 'fetchall' method must be implemented in the child class.")

    def fetchone(self):
        """Fetch a single row from the last executed query."""
        raise NotImplementedError("The 'fetchone' method must be implemented in the child class.")

    def rollback(self):
        """Rollback the current transaction."""
        raise NotImplementedError("The 'rollback' method must be implemented in the child class.")

    def commit(self):
        """Commit the current transaction."""
        raise NotImplementedError("The 'commit' method must be implemented in the child class.")

    def close(self):
        """Close the cursor and connection."""
        raise NotImplementedError("The 'close' method must be implemented in the child class.")
