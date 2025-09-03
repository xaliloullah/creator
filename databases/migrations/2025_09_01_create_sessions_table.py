from src.databases.schema import Table


# Up function for sessions table
def up():
    table = Table('sessions')
    table.id()
    #
    table.timestamps()
    table.create()


# Down function for sessions table
def down():
    table = Table('sessions')
    table.drop()