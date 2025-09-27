from typing import Any

import re
_pattern = re.compile(r'\{(\w+)\}')
_env:dict = {}
_ini = ".env" 
try:
    with open(_ini, 'r') as file:
        for line in file:
            if line and not line.startswith((';', '#')):
                if '=' in line:
                    key, value = line.strip().split('=', 1)
                    value = _pattern.sub(lambda m: _env.get(m.group(1), m.group(0)), value)
                    _env[key] = value 

except:
    pass

def env(name:Any|str, default:Any|str=None):
    return _env.get(name.upper(), default)  