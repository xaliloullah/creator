from src.core import Storage
import uuid
class Player(Storage): 
    def __init__(self, name): 
        self.id = uuid.uuid5(uuid.NAMESPACE_DNS, name)
        self.name = name 
        self.path = f'data/{self.id}' 
        super().__init__(self.path, format="json")  
        
        if self.data:
            self.autoload()
        
    def autoload(self):
        self.level = self.get_data("LEVEL")
        self.xp = self.get_data("XP") 
        
        self.resources = self.get_data("RESOURCES")
        
        self.creatis = self.resources['CREATIS']
        self.rations = self.resources['RATION']
        self.munitions = self.resources['MUNITION']
        self.carburants = self.resources['CARBURANT']
        
        self.unities = self.get_data("UNITIES")
        
        self.soldiers = self.unities['SOLDIER']
        self.tanks = self.unities['TANK']
        self.helicopters = self.unities['HELICOPTER']
        self.drone = self.unities['DRONE']
        self.missile = self.unities['MISSILE']
        
        self.buildings = self.get_data("BUILDINGS")
        
        self.QG = self.buildings['QG'] 
        self.camp = self.buildings['CAMP']
        self.entrepot = self.buildings['ENTREPOT']
        self.cantine = self.buildings['CANTINE']
        self.rafinerie = self.buildings['RAFINERIE']
        self.usine = self.buildings['USINE']
        self.radar = self.buildings['RADAR']
        
    def engage(self, unity):
        if unity in self.unities:  
            return unity
        else:
            print(f"impossible d'engager {unity}.")
            return
        
    def upgrade(self, building):
        if building in self.buildings:
            return 
        
    def train(self, unity):
        pass
    