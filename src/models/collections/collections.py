class BaseCollection:
    def __init__(self, data):
        self.data = data

    def all(self):
        return self.data

    def get(self):
        return self.data

    def json(self):
        import json
        return json.dumps(self.data)

    def __repr__(self):
        return f"{self.__class__.__name__}({self.data})"

    def __str__(self):
        return str(self.data)


class ListCollection(BaseCollection):
    def add(self, item):
        self.data.append(item)

    def remove(self, item):
        if item in self.data:
            self.data.remove(item)

    def update(self, old, new):
        if old in self.data:
            index = self.data.index(old)
            self.data[index] = new
        else:
            self.add(new)

    def count(self):
        return len(self.data)

    def sum(self, key=None):
        return sum(key(x) if key else x for x in self.data)

    def avg(self, key=None):
        return self.sum(key) / len(self.data) if self.data else 0

    def max(self, key=None):
        return max(self.data, key=key) if self.data else None

    def min(self, key=None):
        return min(self.data, key=key) if self.data else None

    def map(self, func):
        return ListCollection(list(map(func, self.data)))

    def filter(self, func):
        return ListCollection(list(filter(func, self.data)))

    def reduce(self, func, initial=None):
        from functools import reduce
        return reduce(func, self.data, initial)

    def chunk(self, size):
        return ListCollection([self.data[i:i+size] for i in range(0, len(self.data), size)])

    def first(self, func=None):
        return next((x for x in self.data if func(x)), None) if func else self.data[0]

    def last(self, func=None):
        return next((x for x in reversed(self.data) if func(x)), None) if func else self.data[-1]

    def find(self, **kwargs):
        for item in self.data:
            if isinstance(item, dict) and all(item.get(k) == v for k, v in kwargs.items()):
                return item
        return None

    def pluck(self, key):
        return ListCollection([item.get(key) for item in self.data if isinstance(item, dict)])

    def merge(self, other):
        self.data += other
        return self


class DictCollection(BaseCollection):
    def get(self, keys=None, default=None):
        data = self.data
        try:
            if keys:
                for key in keys.split('.'):
                    data = data[key]
            return data
        except Exception:
            return default

    def set(self, keys, value):
        keys = keys.split('.')
        d = self.data
        for key in keys[:-1]:
            if key not in d or not isinstance(d[key], dict):
                d[key] = {}
            d = d[key]
        d[keys[-1]] = value

    def to_list(self):
        return list(self.data.items())


class StringCollection(BaseCollection):
    def explode(self, separator):
        return ListCollection(self.data.split(separator))

    def implode(self, separator):
        return StringCollection(separator.join(self.data))

    def replace(self, old, new="", count=-1):
        if isinstance(old, (list, tuple)):
            for item in old:
                self.data = self.data.replace(item, new, count)
        else:
            self.data = self.data.replace(old, new, count)
        return self


# Factory
def Collection(data):
    if isinstance(data, list):
        return ListCollection(data)
    elif isinstance(data, dict):
        return DictCollection(data)
    elif isinstance(data, str):
        return StringCollection(data)
    else:
        return BaseCollection(data)
