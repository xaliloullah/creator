import sys
import subprocess 
from src.core import File, Path

class Task:
    
    @staticmethod    
    def install(package, **kwargs): 
        try:
            version = kwargs.get('version', "")  
            extra_args = kwargs.get('extra_args', []) 
            user = kwargs.get('user', False) 
            quiet = kwargs.get('quiet', False)  
            force_reinstall = kwargs.get('force_reinstall', False)  
            
            command = [sys.executable, '-m', 'pip', 'install']
            
            if version:
                command.append(f"{package}=={version}")
            else:
                command.append(package)
            
            if quiet:
                command.append('--quiet')
            
            if user:
                command.append('--user')
            
            if force_reinstall:
                command.append('--force-reinstall')
            
            if extra_args:
                command.extend(extra_args)
                
            subprocess.check_call(command) 
            
            if not version:
                result = subprocess.run([sys.executable, "-m", "pip", "show", package], capture_output=True, text=True)
                version_line = next(line for line in result.stdout.splitlines() if line.startswith("Version:"))
                version = version_line.split(":")[1].strip()
              
            requirements = File(Path.settings().ensure_exists()).load(format="json")
            requirements["packages"][package] = version
            
            File(Path.settings()).save(requirements, format="json", indent=2) 
        except Exception as e:
            raise Exception(e)   
            
    @staticmethod
    def uninstall(package):
        try:
            subprocess.check_call([sys.executable, '-m', 'pip', 'uninstall', package, '-y']) 
            requirements = File(Path.settings()).load(format="json")
            del requirements["packages"][package]  
            File(Path.settings()).save(requirements, format="json", indent=2) 
        except Exception as e:
            raise Exception(e) 
            
    @staticmethod        
    def execute(*command, **kwargs):
        script = kwargs.get("script", False)
        try:
            cmd = list(command)
            if not script:
                cmd = [sys.executable, '-m'] + cmd
            subprocess.run(cmd, shell=True, check=True)
        except Exception as e:
            raise Exception(e)
    
    @staticmethod
    def run(source:str, *functions, **kwargs):
        namespace=kwargs.get("namespace", {})
        try:  
            with open(source, 'r', encoding='utf-8') as file:
                code = compile(file.read(), source, 'exec') 
                exec(code, namespace)
                for function in functions:
                    if function in namespace:
                        namespace[function]() 
        except Exception as e:
            raise Exception(e)
        
    @staticmethod
    def replace(data:str, old, new="", count=-1): 
        if not isinstance(old, str): 
            for item in old:
                data = data.replace(item, new, count)
        else:
            data = data.replace(old, new, count)
        return data 

    # @staticmethod
    # def explode(separator, data:str): 
    #     return data.split(separator)

    # @staticmethod
    # def implode(separator:str, data:list): 
    #     return separator.join(data)


    # def load_globals(filepath):
    #     globals_dict = {}
    #     with open(filepath, 'r') as f:
    #         code = f.read()
    #         exec(code, globals_dict)
    #     # Retirer les clés inutiles comme '__builtins__'
    #     return {k: v for k, v in globals_dict.items() if not k.startswith('__')}

    # # Exemple :
    # vars_dict = load_globals('mon_fichier.py')
    # print(vars_dict)

     
    @staticmethod   
    def build_import(source:str, *modules) -> str:
        try: 
            source = Task.replace(source, ['/','\\'], '.') 
            if modules:
                return f"from {source} import {', '.join(File(m).path.strip() for m in modules)}"
            
            if '.' in source:
                path, module = source.rsplit('.', 1)
                return f"from {path} import {module}"
            
            return f"import {source}"
            
        except Exception as e:
            raise Exception(e)

    @staticmethod
    def cleans(directory = '.', file= '__pycache__'): 
        File(directory).clean(file)
