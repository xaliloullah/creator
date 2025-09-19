from app.models.auth.user import User 
# from src.databases.model import Model
# from main import Creator

users = User.last() 
print(users.delete())
# print(users.query().generate())
# exit()
# for user in users.get():
#     print(user.abonnements())
# Creator.terminal.table(users, keys=['prenom', 'nom', 'statut'])

# from src.databases.query import Query
# Query("ALTER TABLE users DROP FOREIGN KEY fk_roles;").execute() 
# Query("Alter table users DROP index users_role_id_foreign;").execute() 
# table.column.drop("role_id")

# from src.databases.schema import Table
# table = Table('tests') 
# table.column.id()
# table.column.string("email").unique()
# table.column.foreign_id('user_id').constrained('users').on_delete('cascade').on_update('cascade')
# table.column.integer("age").default(10)
# table.column.decimal("prix", 10, 2).nullable()
# table.column.date("date")
# # print(table.column.generate() )
# table.create() 
# table.drop()
 