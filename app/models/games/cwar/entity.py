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
        self.type: str = kwargs.get("type", "Entity")
        self.required: dict = kwargs.get("required", {})
        self.tags: list[str] = kwargs.get("tags", [self.id, self.name, self.icon])

        
    def get_position(self):
        return self.position
    
    def set_position(self, x, y):
        self.x = x, self.y = y
        self.position = (x, y)

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

 