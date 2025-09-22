from src.databases.schema import Table


# Up function for users table
def up():
    table = Table('users')
    table.column.id()
    table.column.string("name")
    table.column.string("email").unique()
    table.column.string("password")
    table.column.timestamps()
    table.create()


# Down function for users table
def down():
    table = Table('users')
    table.drop()