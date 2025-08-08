from app.models.games.cwar.entity import Entity

class Unity(Entity):

    def __init__(self, name, **kwargs): 
        self.name = name   
        self.quantity:int = kwargs.get("quantity", 0)
        self.attack = kwargs.get("attack", 0)
        self.defense = kwargs.get("defense", 0)
        self.speed = kwargs.get("speed", 0) 
        
        super().__init__(name = self.name, **kwargs)
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