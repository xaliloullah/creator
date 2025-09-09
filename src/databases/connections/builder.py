class DatabaseBuilder:
    """Generic base class for database connectors."""
    syntax = {}
    placeholder ='?'
    
    def __init__(self, config):
        self.connection = None
        self.cursor = None
        self.config = config 
        self.master = '' 

    # def connect(self):
    #     """Establish the database connection."""
    #     raise NotImplementedError("The 'connect' method must be implemented in the child class.")

    def execute(self, query, params=None):
        """Execute a SQL query."""
    #     raise NotImplementedError("The 'execute' method must be implemented in the child class.")

    # def fetchall(self):
    #     """Fetch all rows from the last executed query."""
    #     raise NotImplementedError("The 'fetchall' method must be implemented in the child class.")

    # def fetchone(self):
    #     """Fetch a single row from the last executed query."""
    #     raise NotImplementedError("The 'fetchone' method must be implemented in the child class.")

    # def close(self):
    #     """Close the cursor and connection."""
    #     raise NotImplementedError("The 'close' method must be implemented in the child class.")
