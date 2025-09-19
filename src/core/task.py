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
            venv = kwargs.get("venv", False)
            command = ['pip', 'install']
            
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
                
            Task.execute(*command, venv=venv) 
            
            if not version:
                result = Task.execute("pip", "show", package, capture_output=True, text=True, venv=venv)
                version_line:str = next(line for line in result.stdout.splitlines() if line.startswith("Version:"))
                version = version_line.split(":")[1].strip()
              
            requirements = File(Path.settings().ensure_exists()).load(format="json")
            requirements["required"][package] = version
            
            File(Path.settings()).save(requirements, format="json", indent=2) 
        except Exception as e:
            raise Exception(e)   
            
    @staticmethod
    def uninstall(package, venv=False):
        try:
            Task.execute('pip', 'uninstall', package, '-y', venv=venv) 
            requirements = File(Path.settings()).load(format="json")
            del requirements["required"][package]  
            File(Path.settings()).save(requirements, format="json", indent=2) 
        except Exception as e:
            raise Exception(e) 
            
    @staticmethod        
    def execute(*command, **kwargs):
        import os 
        shell = kwargs.get("shell", False)
        capture_output = kwargs.get("capture_output", False)
        text = kwargs.get("text", False) 
        check = kwargs.get("check", True)
        venv = kwargs.get("venv", False)

        executable = sys.executable
        if venv:
            if os.name == 'nt':
                python = Path.environment("python").join("Scripts\\python.exe").absolute()
            else:
                python = Path.environment("python").join("bin/python").absolute()
            if File(python).exists():
                executable=python.get()
        try:
            cmd = list(command)
            if not shell:
                cmd = [executable, '-m'] + cmd
            result = subprocess.run(cmd, shell=shell, check=check, capture_output=capture_output, text=text)
            if capture_output:
                return result
        except Exception as e:
            raise Exception(e)
    
    @staticmethod
    def run(source:str, **kwargs):
        namespace=kwargs.get("namespace", {})
        functions=kwargs.get("functions", [])
        only=kwargs.get("only", None)
        ignore=kwargs.get("ignore", None)

        try:  
            with open(source, 'r', encoding='utf-8') as file:
                code = compile(file.read(), source, 'exec') 
                exec(code, namespace) 

                if functions == '*' or functions == ["*"]:
                    functions = [func for func in namespace if callable(namespace[func])]

                for function in functions:
                    if function in namespace:
                        namespace[function]() 
        except Exception as e:
            raise Exception(e)
         
    @staticmethod   
    def build_import(source:str, *modules) -> str:
        from src.core import String
        try: 
            source = String(source).replace(['/','\\'], '.') 
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
