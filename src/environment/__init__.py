_env = {}
_ini = ".env"
try:
    with open(_ini, 'r') as file:
        for line in file:
            if line and not line.startswith((';', '#')):
                if '=' in line:
                    key, value = line.strip().split('=', 1)
                    _env[key] = value
except:
    pass
                
def env(name: str, default=None):
    return _env.get(name.upper(), default)  