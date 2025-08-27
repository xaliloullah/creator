import sys
import os
 
sys.path.append(os.path.abspath(os.path.join(__file__, "..", "..")))

from app.models.games.cwg import Cwar

game = Cwar()
#
# game.update_unity(game.soldier, 100)
# game.update_unity(game.tank, 120)
# #
# game.update_resource(game.creatis, 1000)
# game.update_resource(game.creatis, -100)
# #
# game.upgrate_building(game.caserne)
# #
# game.update()
# print(game.caserne.required)
# print("Resources")
# for resource in game.resources:
#     print(resource.icon, resource.name, resource.quantity)

# print()

# print("Unities")
# for unity in game.unities:
#     print(unity.icon, unity.name, unity.quantity)

# print()

# print("Buildings")
# for building in game.buildings:
#     print(building.icon, building.name, building.level)  
 