class Dict(dict):  
    
    def get(self, key, default=None):
        keys = key.split(".")
        current = self
        for key in keys:
            if isinstance(current, dict) and key in current:
                current = current[key]
            else:
                return default
        return current
    
    def set(self, key, value):
        keys = key.split(".")
        current = self
        for key in keys[:-1]:
            if key not in current or not isinstance(current[key], dict):
                current[key] = {}
            current = current[key]
        current[keys[-1]] = value
        return self
    
    def sort_by_key(self, reverse=False): 
        return Dict(sorted(self.items(), key=lambda item: item[0], reverse=reverse))
    
    def sort_by_value(self, reverse=False): 
        return Dict(sorted(self.items(), key=lambda item: item[1], reverse=reverse))
    
    def keys_list(self):
        return list(self.keys())
    
    def values_list(self):
        return list(self.values())
    
    def items_list(self):
        return list(self.items()) 
    
    def merge(self, other): 
        result = Dict(self)
        result.update(other)
        return result
     
    def invert(self): 
        return Dict({value: key for key, value in self.items()})
    
    def keys_contain(self, substring): 
        return any(substring in str(key) for key in self.keys())
    
    def values_contain(self, substring): 
        return any(substring in str(value) for value in self.values())
    
    def unique(self): 
        return set(self.values())