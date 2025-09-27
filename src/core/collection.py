import random

class Collection:
    def __init__(self, items=None):
        self.items:list = list(items) if items else []

    def all(self):
        return self.items
    
    
    def __repr__(self):
        return f"Collection({self.items})"

    # ------------------------------
    # Extraction
    # ------------------------------
    def first(self, default=None):
        return self.items[0] if self.items else default

    def last(self, default=None):
        return self.items[-1] if self.items else default

    def get(self, index, default=None):
        return self.items[index] if 0 <= index < len(self.items) else default

    def set(self, index, value):
        if 0 <= index < len(self.items):
            self.items[index] = value
        return self

    def take(self, n):
        return Collection(self.items[:n])

    def skip(self, n):
        return Collection(self.items[n:])

    def chunk(self, size):
        return [Collection(self.items[i:i+size]) for i in range(0, len(self.items), size)]

    def nth(self, step, offset=0):
        return Collection(self.items[offset::step])

    def random(self, n=1):
        return Collection(random.sample(self.items, n))

    def shuffle(self):
        items = self.items[:]
        random.shuffle(items)
        return Collection(items)

    # ------------------------------
    # Transformation
    # ------------------------------
    def map(self, func):
        return Collection([func(item) for item in self.items])

    def filter(self, func):
        return Collection([item for item in self.items if func(item)])

    def reject(self, func):
        return Collection([item for item in self.items if not func(item)])

    def each(self, func):
        for item in self.items:
            func(item)
        return self

    def pluck(self, key):
        return Collection([item[key] for item in self.items if isinstance(item, dict) and key in item])

    def group_by(self, key):
        grouped = {}
        for item in self.items:
            if isinstance(item, dict) and key in item:
                grouped.setdefault(item[key], []).append(item)
        return {k: Collection(v) for k, v in grouped.items()}

    def sort(self, key=None, reverse=False):
        return Collection(sorted(self.items, key=key, reverse=reverse)) 
    
    def flatten(self):
        flat = []
        for item in self.items:
            if isinstance(item, (list, tuple, Collection)):
                flat.extend(Collection(item).flatten().all())
            else:
                flat.append(item)
        return Collection(flat)

    def values(self):
        return Collection(list(self.items))

    def keys(self):
        if all(isinstance(item, dict) for item in self.items):
            return Collection([list(item.keys()) for item in self.items]).flatten().unique()
        return Collection(range(len(self.items)))

    def unique(self):
        return Collection(list(dict.fromkeys(self.items)))

    def concat(self, other):
        return Collection(self.items + list(other))

    def merge(self, other):
        return self.concat(other)

    def zip(self, other):
        return Collection(list(zip(self.items, other)))

    def combine(self, values):
        return Collection(dict(zip(self.items, values)))

    def cross_join(self, other):
        return Collection([(a, b) for a in self.items for b in other])

    # ------------------------------
    # Agrégations
    # ------------------------------
    def sum(self):
        return sum(self.items)

    def avg(self):
        return sum(self.items) / len(self.items) if self.items else 0

    def max(self):
        return max(self.items) if self.items else None

    def min(self):
        return min(self.items) if self.items else None

    def count(self):
        return len(self.items)

    def implode(self, sep=","):
        return sep.join(map(str, self.items))

    def join(self, sep=", ", last=" and "):
        if len(self.items) <= 1:
            return "".join(map(str, self.items))
        return sep.join(map(str, self.items[:-1])) + last + str(self.items[-1])

    def reduce(self, func, initial=None):
        result = initial
        for item in self.items:
            result = func(result, item) if result is not None else item
        return result

    # ------------------------------
    # Comparaisons & inclusion
    # ------------------------------
    def contains(self, value):
        if callable(value):
            return any(value(item) for item in self.items)
        return value in self.items

    def diff(self, other):
        return Collection([item for item in self.items if item not in other])

    def intersect(self, other):
        return Collection([item for item in self.items if item in other])

    def except_keys(self, keys):
        return Collection([{k: v for k, v in d.items() if k not in keys} for d in self.items if isinstance(d, dict)])

    def only(self, keys):
        return Collection([{k: v for k, v in d.items() if k in keys} for d in self.items if isinstance(d, dict)])

    def where(self, **kwargs):
        def matches(item):
            if not isinstance(item, dict):
                return False
            return all(item.get(k) == v for k, v in kwargs.items())
        
        return Collection([item for item in self.items if matches(item)])


    def where_in(self, key, values):
        return Collection([item for item in self.items if isinstance(item, dict) and item.get(key) in values])

    def where_not_in(self, key, values):
        return Collection([item for item in self.items if isinstance(item, dict) and item.get(key) not in values])

    def where_null(self, key):
        return Collection([item for item in self.items if isinstance(item, dict) and item.get(key) is None])

    def where_not_null(self, key):
        return Collection([item for item in self.items if isinstance(item, dict) and item.get(key) is not None])

    # ------------------------------
    # Helpers "conditionnels"
    # ------------------------------
    def when(self, condition, func):
        return func(self) if condition else self

    def unless(self, condition, func):
        return func(self) if not condition else self

    # ------------------------------
    # Magic
    # ------------------------------
    def __iter__(self):
        return iter(self.items)

    def __len__(self):
        return len(self.items)

    def __getitem__(self, index):
        return self.items[index]