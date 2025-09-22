import sys
import subprocess  
from src.core import File, Path, List
import threading

class Task:

    @classmethod
    def thread(cls, target, *args, **kwargs):
        thread = threading.Thread(target=target, args=args, kwargs=kwargs)
        thread.start()
        return thread
    
    @staticmethod    
    def install(package, **kwargs): 
        try:
            upgrade = kwargs.get('upgrade', False)  
            version = kwargs.get('version', "")  
            extra_args = kwargs.get('extra_args', []) 
            user = kwargs.get('user', False) 
            quiet = kwargs.get('quiet', False)  
            force = kwargs.get('force', False)  
            venv = kwargs.get("venv", False)
            command = ['pip', 'install']
            
            if upgrade:
                command.append("--upgrade")
            if version:
                command.append(f"{package}=={version}")
            else:
                command.append(package)
            if quiet:
                command.append('--quiet')
            if user:
                command.append('--user')
            if force:
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
    def update(package, **kwargs):
        kwargs['upgrade'] = True
        Task.install(package, **kwargs)

    @staticmethod
    def list_installed(venv=False):
        try:
            result = Task.execute("pip", "list", capture_output=True, text=True, venv=venv)
            return result.stdout
        except Exception as e:
            raise Exception(e)
        
    @staticmethod
    def freeze(output_file="requirements.txt", venv=False):
        try:
            result = Task.execute("pip", "freeze", capture_output=True, text=True, venv=venv)
            File(output_file).save(result.stdout, format="text")
        except Exception as e:
            raise Exception(e)
        
    @staticmethod
    def check_updates(venv=False):
        try:
            result = Task.execute("pip", "list", "--outdated", capture_output=True, text=True, venv=venv)
            return result.stdout
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
    def run(source:str, *filters, **kwargs):
        namespace:dict=kwargs.get("namespace", {})  
        try:  
            with open(source, 'r', encoding='utf-8') as file:
                code = compile(file.read(), source, 'exec') 
                exec(code, namespace) 

                if filters:
                    functions = List([func for func in namespace if callable(namespace[func])]).filter(*filters)
                    for function in functions:
                        if function in namespace:
                            namespace[function]() 
        except Exception as e:
            raise Exception(e)
         
    @staticmethod
    def cleans(directory = '.', file= '__pycache__'): 
        File(directory).clean(file)

    @staticmethod
    def schedule(func, delay=5, *args, **kwargs):
        import time, threading
        try:
            def wrapper():
                time.sleep(delay)
                func(*args, **kwargs)
            threading.Thread(target=wrapper).start()
        except Exception as e:
            raise Exception(e)
        
    @staticmethod
    def system_info():
        import platform, sys
        try:
            return {
                "os": platform.system(),
                "os_version": platform.version(),
                "machine": platform.machine(),
                "python_version": sys.version,
                "python_executable": sys.executable,
            }
        except Exception as e:
            raise Exception(e)
        
    @staticmethod
    def timer(func, *args, **kwargs):
        import time
        try:
            start = time.time()
            result = func(*args, **kwargs)
            duration = time.time() - start
            return {"result": result, "time": duration}
        except Exception as e:
            raise Exception(e)


