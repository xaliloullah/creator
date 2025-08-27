from src.core import Path, Task 


class View:
    data = {}
    history = [] 
    
    def __init__(self, path:str=None, *args):
        try: 
            view = self.path(path)
            if args:
                args
            self.set_history(view)
            self.show(view)
        except Exception as e:
            raise Exception(e) 
            
    @staticmethod
    def include(view:str, *args): 
        args if args else None
        return View.show(View.path(view))  
    
    @staticmethod
    def show(view:str): 
        from config import app 
        if app.mode == 'web':
            from flask import render_template
            return render_template(View.path(view), **View.data)
        return Task.run(View.path(view), "view")
    
    @staticmethod
    def path(path):
        return path if isinstance(path, Path) else Path.views(path)

    @classmethod   
    def get(cls, key):
        return cls.data.get(key)

    @classmethod
    def set(cls, key, value):
        cls.data[key] = value
        
    @classmethod
    def share(cls, data):
        cls.data.update(data)
        
    @classmethod   
    def get_history(cls):
        return cls.history

    @classmethod
    def set_history(cls, arg):
        cls.history.append(arg)

    @classmethod
    def compact(cls, **kwargs):
        for key, value in kwargs.items():
            cls.set(key, value)
            
    @classmethod
    def back(cls):
        if len(cls.history) > 1:  
            cls.history.pop()   
            previous = cls.history[-1]
            cls.show(previous)

    @classmethod
    def section(cls, key, value=None):  
        def decorator(function):
            def wrapper(*args, **kwargs):
                if value: 
                    cls.set(key, value)
                    return function(*args, **kwargs)  
                else:
                    cls.set(key, {'action': function, 'args': args, 'kwargs': kwargs}) 
                    return
            return wrapper
        return decorator

    @classmethod
    def extend(cls, path): 
        def decorator(function):
            def wrapper(*args, **kwargs):  
                function(*args, **kwargs)
                cls.show(path) 
                return 
            return wrapper 
        return decorator

    @classmethod
    def generate(cls, name):  
        result = cls.get(name)  
        if isinstance(result, dict): 
            return result['action'](*result['args'], **result['kwargs']) 
        elif result:   
            return result
        else:
            return "" 
        
    def render(path, context={}):
        import re
        with open(path, "r", encoding="utf-8") as f:
            content = f.read()

        # Injection des variables
        for key, value in context.items():
            content = content.replace(f"{{{{ {key} }}}}", str(value))

        # Exécuter les blocs @py ... @endpy
        py_blocks = re.findall(r"@py(.*?)@endpy", content, flags=re.DOTALL)
        for block in py_blocks:
            exec(block.strip(), context)
        content = re.sub(r"@py.*?@endpy", "", content, flags=re.DOTALL)

        # Boucles simples @for ... @endfor
        def for_repl(match):
            code = match.group(1).strip()
            lines = code.split("\n")
            first = lines[0]  # ex: for item in items
            body = "\n".join(lines[1:])
            result = ""
            exec(f"for {first[4:]}:\n    _body_result = '''{body}'''\n    print(_body_result)", context)
            return ""  # temporaire, on peut améliorer

        content = re.sub(r"@for(.*?)@endfor", for_repl, content, flags=re.DOTALL)

        # Conditions simples (à compléter)
        content = re.sub(r"@if(.*?)\n", "", content)
        content = re.sub(r"@endif", "", content)

        return content
