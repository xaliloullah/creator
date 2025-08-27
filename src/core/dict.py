class DictList(list):

    def find(self, value): 
        return DictList([d for d in self if isinstance(d, dict) and value in d.values()])

    def where(self, **kwargs): 
        result = []
        for d in self:
            if not isinstance(d, dict):
                continue
            match = all(d.get(k) == v for k, v in kwargs.items())
            if match:
                result.append(d)
        return DictList(result)


class Dict(dict):
    def first(self, n=1): 
        items = list(self.items())[:n]
        return Dict(items)
    
    def last(self, n=1): 
        items = list(self.items())[-n:]
        return Dict(items)
    
    def where(self, func=None, **kwargs): 
        if func:
            return Dict({k: v for k, v in self.items() if func(k, v)})
        elif kwargs:
            return Dict({k: v for k, v in self.items() if k in kwargs and v == kwargs[k]})
        else:
            return Dict(self)
    
    def find(self, value): 
        return Dict({k: v for k, v in self.items() if v == value})
        
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
    
    def filter_keys(self, func): 
        return Dict({k: v for k, v in self.items() if func(k)})
    
    def filter_values(self, func): 
        return Dict({k: v for k, v in self.items() if func(v)})
    
    def map_values(self, func): 
        return Dict({k: func(v) for k, v in self.items()})
    
    def map_keys(self, func): 
        return Dict({func(k): v for k, v in self.items()})
    
    def invert(self): 
        return Dict({v: k for k, v in self.items()})
    
    def keys_contain(self, substring): 
        return any(substring in str(k) for k in self.keys())
    
    def values_contain(self, substring): 
        return any(substring in str(v) for v in self.values())
    
    def unique_values(self): 
        return set(self.values())
    
    def sum_values(self): 
        return sum(v for v in self.values() if isinstance(v, (int, float)))
    

# Création d'un dictionnaire personnalisé
data = Dict({
    "name": "Alice",
    "friend": "Alice",
    "age": 25,
    "city": "Paris"
})


# Obtenir la liste des clés
print(data.keys_list())  
# Sortie: ['apple', 'banana', 'cherry', 'date']

# Obtenir la liste des valeurs
print(data.values_list())  
# Sortie: [5, 2, 5, 7]

# Fusionner avec un autre dictionnaire
other = Dict({"banana": 10, "elderberry": 3})
merged = data.merge(other)
print(merged)  
# Sortie: {'apple': 5, 'banana': 10, 'cherry': 5, 'date': 7, 'elderberry': 3}

 
# Sortie: {'apple': 10, 'banana': 4, 'cherry': 10, 'date': 14}

# Inverser clés et valeurs
inverted = data.invert()
print(inverted)  
# Sortie: {5: 'cherry', 2: 'banana', 7: 'date'}  # note: 'apple' écrasé car même valeur 5

# Vérifier si certaines clés contiennent 'a'
print(data.keys_contain('a'))  
# Sortie: True  (apple, banana, date contiennent 'a')

# Obtenir la somme des valeurs
print(data.sum_values())  
# Sortie: 19  (5 + 2 + 5 + 7)
