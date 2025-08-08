from app.models.games.cwar.entity import Entity

class Resource(Entity):

    def __init__(self, name, **kwargs): 
        self.name = name  
        self.quantity = kwargs.get("quantity", 0)

        super().__init__(name = self.name, **kwargs)
        # 

    def generate(self, position, quantity): 
        return self, position, quantity
    
    def update(self, quantity):
        self.quantity+=quantity

    def __str__(self):
        return f"{self.name}:{self.quantity}"
