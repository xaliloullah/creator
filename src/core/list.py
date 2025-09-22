import random  
from itertools import chain
import fnmatch

class List(list):
     
    def unique(self):
        seen = set()
        return List([x for x in self if not (x in seen or seen.add(x))])
     
    def shuffle(self):
        temp = self.copy()
        random.shuffle(temp)
        return List(temp) 
     
    def flatten(self):
        return List(list(chain.from_iterable(
            x if isinstance(x, (list, tuple)) else [x] for x in self
        )))
     
    def chunk(self, size):
        return List([List(self[i:i+size]) for i in range(0, len(self), size)])
     
    def reverse(self):
        return List(self[::-1])
     
    def random(self):
        if not self:
            return None
        return random.choice(self)
     
    def uniform_type(self):
        return all(isinstance(x, type(self[0])) for x in self) if self else True
     
    def first(self, n=1):
        return List(self[:n])
     
    def last(self, n=1):
        return List(self[-n:])
     
    def contains(self, item):
        return item in self
     
    def remove(self, items):
        if not isinstance(items, (list, tuple, set)):
            items = [items]
        return List([x for x in self if x not in items])
     
    def map(self, func):
        return List([func(x) for x in self])
     
    def filter(self, *args, ignore:str= None):
        functions = []
        patterns = []
        ignores = ignore.split(",") if ignore else []
        for arg in args:
            if callable(arg):
                functions.append(arg)
            else:
                patterns.append(arg)
        def match(items): 
            if functions and not all(function(items) for function in functions):
                return False 
            if ignores and any(fnmatch.fnmatch(str(items), ignore.strip()) for ignore in ignores):
                return False
            if patterns and not all(fnmatch.fnmatch(str(items), pattern) for pattern in patterns):
                return False
            return True
        return List([items for items in self if match(items)])
     
    def index(self, item):
        try:
            return self.index(item)
        except ValueError:
            return -1
     
    def sort(self, key=None, reverse=False):
        return List(sorted(self, key=key, reverse=reverse))
     
    def merge(self, other):
        return List(self + list(other)) 
    
    def sum(self):
        return sum(self) 
    
    def unique_count(self):
        return len(set(self))
    
    def pop_random(self):
        if not self:
            return None
        index = random.randrange(len(self))
        return self.pop(index)
    
    def rotate(self, n=1):
        n = n % len(self) if self else 0
        return List(self[-n:] + self[:-n])
    
    def all_match(self, func):
        return all(func(x) for x in self)
    
    def any_match(self, func):
        return any(func(x) for x in self)
    
    def clear(self):
        super().clear()
        return self  
    
    def pluck(self, key):
        return List([item[key] for item in self.items if isinstance(item, dict) and key in item])
