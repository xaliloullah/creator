from typing import Any, Callable, Dict, List 
from src.core import Task
class Event:
    data: Dict[Any, List] = {}
 
    @classmethod
    def listen(cls, name:str, callback:Callable, once:bool=False): 
        if name not in cls.data:
            cls.data[name] = [] 
        if once:
            def wrapper(*args, **kwargs):
                callback(*args, **kwargs)
                cls.remove(name, wrapper)
            cls.data[name].append(wrapper)
        else:
            cls.data[name].append(callback)

    @classmethod
    def emit(cls, name:str, *args, **kwargs):
        if name in cls.data:
            for callback in cls.data[name][:]:
                Task.do(callback, *args, **kwargs).start()


    @classmethod
    def remove(cls, name, callback):
        if name in cls.data:
            try:
                cls.data[name].remove(callback)
            except ValueError:
                pass

    @classmethod
    def clear(cls, name=None):
        if name:
            if name in cls.data:
                del cls.data[name]
        else:
            cls.data.clear()