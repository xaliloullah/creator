from app.models.games.cwar.entity import Entity

class World(Entity):
    def __init__(self, name, **kwargs):
        self.name=name
        super().__init__(name=self.name, **kwargs) 

    