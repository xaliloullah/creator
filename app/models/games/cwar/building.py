from app.models.games.cwar.entity import Entity

class Building(Entity):

    def __init__(self, name, **kwargs):
        self.name = name  
        self.level = kwargs.get("level", 1)
        self.required = kwargs.get("required", {})
        self.storage = kwargs.get("storage", 0)
        self.production = kwargs.get("production", {})
        self.engageable = kwargs.get("engageable", [])
        self.capacity = kwargs.get("capacity", 0)
        
        super().__init__(name=self.name, **kwargs)
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
