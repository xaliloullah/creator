from src.core import Storage
ENTITY="ENTITY"
RESOURCE="RESOURCE" 
UNITY="UNITY"
BUILDING="BUILDING"
# ResourceType
CREATIS="CREATIS"
RATION="RATION"
MUNITION="MUNITION"
CARBURANT="CARBURANT"
# UnityType
SOLDIER = "SOLDIER"
TANK = "TANK"
HELICOPTER = "HELICOPTER"
DRONE = "DRONE"
MISSILE = "MISSILE"
# BuildingType
QG = "QG"
CASERNE = "CASERNE"
ENTREPOT = "ENTREPOT"
REFECTOIRE = "REFECTOIRE"
RAFINERIE = "RAFINERIE"
USINE = "USINE"
RADAR = "RADAR"

class Entity: 
    ID = 0
    def __init__(self, **kwargs): 
        Entity.ID += 1
        self.id = f"{Entity.ID:03}"

        # Identité & Apparence
        self.name: str = kwargs.get("name", f"Entity_{self.id}")
        self.value: str = kwargs.get("value", None)
        self.image: str = kwargs.get("image", None)
        self.icon: str = kwargs.get("icon", "🪖")

        # Dimensions & Position
        self.width: int = kwargs.get("width", 0)
        self.height: int = kwargs.get("height", self.width)
        self.size: list[int] = kwargs.get("size", [self.width, self.height])
        self.width, self.height = self.size  # Assure la cohérence
        self.position: list[int] = kwargs.get("position", [0, 0])
        self.x, self.y = self.position

        # Propriétés de Gameplay
        self.movable: bool = kwargs.get("movable", False)
        self.destroyable: bool = kwargs.get("destroyable", False)
        self.stackable: bool = kwargs.get("stackable", False)
        self.visible: bool = kwargs.get("visible", True)

        # Métadonnées
        self.description: str = kwargs.get("description", "Entity") 
        self.required: dict = kwargs.get("required", {})
        self.tags: list[str] = kwargs.get("tags", [self.id, self.name, self.icon])
        self.data = kwargs

        
    def get_position(self):
        return self.position
    
    def set_position(self, x, y):
        self.x = x
        self.y = y
        self.position = [self.x, self.y]

    def get_stack(self):
        return self.stack
    
    def set_stack(self, stack):
        if self.stackable:
            self.stack = stack

    def get_icon(self):
        return self.icon
    
    def set_icon(self, icon): 
        self.icon = icon
            
    def move(self, x, y):
        if self.movable:
            self.set_position(x, y)  
            
    def get_size(self):
        return self.width, self.height
    
    def set_size(self, width, height = None):
        self.width = width
        self.height = height or width
        
    def set_image(self, image):
        self.image = image
        
    def get_image(self):
        return self.image
    
    def toggle_visibility(self):
        self.visible = not self.visible  

    def has_tag(self, tag: str) -> bool: 
        return tag in self.tags
    
    def info(self):
        return f"{self.icon} {self.name} (ID: {self.id}) {self.data}"
    
class World(Entity):
    def __init__(self, name, **kwargs):
        super().__init__(name=name, **kwargs)

class Resource(Entity):
    def __init__(self, name, **kwargs):  
        self.quantity = kwargs.get("quantity", 0)

        super().__init__(name=name, **kwargs)
        # 

    # def generate(self, position, quantity): 
    #     return self, position, quantity
    
    def update(self, quantity):
        self.quantity+=quantity

    def __str__(self):
        return f"{self.name}:{self.quantity}"
    
class Building(Entity):
    def __init__(self, name, **kwargs):
        self.level = kwargs.get("level", 1)
        self.required = kwargs.get("required", {})
        self.storage = kwargs.get("storage", 0)
        self.production = kwargs.get("production", {})
        self.engageable = kwargs.get("engageable", [])
        self.capacity = kwargs.get("capacity", 0)
        
        super().__init__(name=name, **kwargs)
        # 

    def produce(self):
        return self.production
    
    # def engage(self, unity):
    #     if unity in self.engageable:
    #         return self.engageable[unity]
    #     else:
    #         print(f"impossible d'engager {unity} dans {self.name}")
    
    def upgrate(self, level=1):
        self.level += level

class Unity(Entity):
    def __init__(self, name, **kwargs): 
        self.quantity:int = kwargs.get("quantity", 0)
        self.attack = kwargs.get("attack", 0)
        self.defense = kwargs.get("defense", 0)
        self.speed = kwargs.get("speed", 0) 
        
        super().__init__(name=name, **kwargs)
        # 

    @property
    def attack(self):
        return self._attack_ * int(self.quantity)

    @attack.setter
    def attack(self, value):
        self._attack_ = int(value)

    @property
    def defense(self):
        return self._defense_ * int(self.quantity)

    @defense.setter
    def defense(self, value):
        self._defense_ = int(value)

    @property
    def speed(self):
        return self._speed_ * 1 if int(self.quantity) else 0

    @speed.setter
    def speed(self, value):
        self._speed_ = int(value)


    def update(self, quantity):
        self.quantity+=quantity

class Player:
    def __init__(self, data:Storage):   
        self.level=Entity(name="Level", value=1, icon="🚩") 
        self.xp=Entity(name="XP", value=0, icon="🌟") 

        # Resource
        self.creatis=Resource(CREATIS, icon="💵", image='')
        self.ration=Resource(RATION, icon="🍎")
        self.munition=Resource(MUNITION, icon="📦")
        self.carburant=Resource(CARBURANT, icon="⛽")
        # 
        self.resources=[self.creatis, self.ration, self.munition, self.carburant]

        # Unity
        self.soldier=Unity(SOLDIER, attack=50, defense=30, speed=10, icon="👥")
        self.tank=Unity(TANK, attack=80, defense=100, speed=70, icon="🚜")  
        self.helicopter=Unity(HELICOPTER, attack=120, defense=40, speed=300, icon="🚁")  
        self.drone=Unity(DRONE, attack=500, defense=40, speed=1000, icon="🛬")   
        self.missile=Unity(MISSILE, attack=1000, defense=5, speed=3600, icon="🚀") 
        # 
        self.unities=[self.soldier, self.tank, self.helicopter, self.drone, self.missile]

        # Building
        self.QG=Building(QG, icon="🏨") 
        self.entrepot=Building(ENTREPOT, storage=3000, icon="🏪") 
        self.refectoire=Building(REFECTOIRE, storage=3000, icon="🏠")
        self.rafinerie=Building(RAFINERIE, storage=3000, icon="🏭")
        self.caserne=Building(CASERNE, storage=100, icon="🏥", engageable=[self.soldier])
        self.usine=Building(USINE, storage=50, icon="🏬", engageable=[self.tank, self.helicopter, self.drone, self.missile])
        self.radar=Building(RADAR, icon="🗼")
        # 
        self.buildings=[self.QG, self.caserne, self.entrepot, self.refectoire, self.rafinerie, self.usine, self.radar]
        # 
        self.entities=[self.resources, self.unities, self.buildings]

class Cwar(Storage):
    def __init__(self, path="games/cwar", **kwargs):
        self.path = path
        super().__init__(self.path, format="json", absolute=True, default={}) 
        self.data = self.load() or {} 
        self.fps=self.data.get("fps", 1)
        self.tick=self.data.get("tick", 0)
        self.player = Player(self.data.get("player", {}))

    def settings(self, **kwargs):
        pass  

    def update_required(self): 
        self.player.soldier.required={
            RESOURCE:{self.player.creatis:5, self.player.ration:3, self.player.munition:2},
            BUILDING:{self.player.usine:2},
            ENTITY:{self.player.level:1}
        } 

        self.player.tank.required={
            RESOURCE:{self.player.creatis:100, self.player.munition:30, self.player.carburant:50},
            BUILDING:{self.player.usine:2},
            ENTITY:{self.player.level:5}
        }

        self.player.helicopter.required={
            RESOURCE:{self.player.creatis:350, self.player.munition:180, self.player.carburant:130},
            BUILDING:{self.player.usine:3},
            ENTITY:{self.player.level:10}
        }

        self.player.drone.required={
            RESOURCE:{self.player.creatis:500, self.player.munition:100, self.player.carburant:500},
            BUILDING:{self.player.usine:5},
            ENTITY:{self.player.level:15}
        }

        self.player.missile.required={
            RESOURCE:{self.player.creatis:10000, self.player.munition:2500, self.player.carburant:5000},
            BUILDING:{self.player.usine:10},
            ENTITY:{self.player.level:20}
        }
        
        #    
        self.player.QG.required={
            RESOURCE:{self.player.creatis:5000, self.player.ration:5000, self.player.munition:5000, self.player.carburant:5000},
            BUILDING:{self.player.QG:1},
            ENTITY:{self.player.level:5}
        }

        self.player.caserne.required={
            RESOURCE:{self.player.creatis:1000, self.player.ration:2000, self.player.munition:1500, self.player.carburant:500},
            BUILDING:{self.player.QG:1},
            ENTITY:{self.player.level:5}
        }

        self.player.entrepot.required={
            RESOURCE:{self.player.creatis:2000, self.player.ration:1000, self.player.munition:1500, self.player.carburant:1500},
            BUILDING:{self.player.QG:1},
            ENTITY:{self.player.level:5}
        }

        
        self.player.refectoire.required={
            RESOURCE:{self.player.creatis:2000, self.player.ration:1000, self.player.munition:1500, self.player.carburant:1500},
            BUILDING:{self.player.QG:1},
            ENTITY:{self.player.level:5}
        }

        
        self.player.rafinerie.required={
            RESOURCE:{self.player.creatis:2000, self.player.ration:1000, self.player.munition:1500, self.player.carburant:1500},
            BUILDING:{self.player.QG:1},
            ENTITY:{self.player.level:5}
        }

        self.player.usine.required={
            RESOURCE:{self.player.creatis:5000, self.player.ration:3000, self.player.munition:4500, self.player.carburant:2500},
            BUILDING:{self.player.QG:1},
            ENTITY:{self.player.level:5}
        }

        self.player.radar.required={
            RESOURCE:{self.player.creatis:3000, self.player.ration:2000, self.player.munition:2500, self.player.carburant:2500},
            BUILDING:{self.player.QG:1},
            ENTITY:{self.player.level:5}
        }

    def update_production(self):
        self.player.refectoire.production={self.player.ration:10}
        self.player.rafinerie.production={self.player.carburant:10}
        self.player.usine.production={self.player.munition:10} 
     
    def update_unity(self, unity:Unity, quantity):
        if  unity in self.player.unities:  
            unity.update(quantity)
        
    def update_resource(self, resource:Resource, quantity):
        if  resource in self.player.resources:
            resource.update(quantity)

    def upgrade_building(self, building:Building, level=1):
        if  building in self.player.buildings:
            building.upgrate(level)

    def update(self):
        self.tick += 1 
        self.update_production()
        self.update_required()

    def gameplay(self):
        # refecoire produit 10 * refectoire.level rations
        # rafinerie produit 10 * refectoire.level carburants
        # usine produit 10 * refectoire.level munitions

        # options player : 
        #   Engage unites
        #   Upgrade building

        pass  