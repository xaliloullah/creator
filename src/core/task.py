import sys, subprocess, threading, time
from datetime import datetime, timedelta
from src.core import File, Path, List
from typing import Any, Callable, Optional
 

class Task:

    @classmethod
    def wait(cls, callback:Callable, timeout: float = 10.0, interval: float = 0.5, *args, **kwargs): 
        start_time = time.monotonic()
        while True:
            if callback(*args, **kwargs):
                return True
            if time.monotonic() - start_time > timeout:
                raise TimeoutError(f"Condition not met after {timeout}s")
            time.sleep(interval) 

    @classmethod
    def do(cls, func, *args, **kwargs):
        return Scheduler(func, *args, **kwargs)
    
    @classmethod    
    def install(cls, package, **kwargs): 
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
                result:subprocess.CompletedProcess|Any = Task.execute("pip", "show", package, capture_output=True, text=True, venv=venv)
                version_line:str = next(line for line in result.stdout.splitlines() if line.startswith("Version:"))
                version = version_line.split(":")[1].strip()
              
            requirements = File(Path.settings().ensure_exists()).load(format="json")
            requirements["required"][package] = version
            
            File(Path.settings()).save(requirements, format="json", indent=2) 
        except Exception as e:
            raise Exception(e)   
            
    @classmethod
    def uninstall(cls, package, venv=False):
        try:
            Task.execute('pip', 'uninstall', package, '-y', venv=venv) 
            requirements = File(Path.settings()).load(format="json")
            del requirements["required"][package]  
            File(Path.settings()).save(requirements, format="json", indent=2) 
        except Exception as e:
            raise Exception(e) 
            
    @classmethod
    def update(cls, package, **kwargs):
        kwargs['upgrade'] = True
        Task.install(package, **kwargs)

    @classmethod
    def list_installed(cls, venv=False):
        try:
            result:subprocess.CompletedProcess|Any = Task.execute("pip", "list", capture_output=True, text=True, venv=venv)
            return result.stdout
        except Exception as e:
            raise Exception(e)
        
    @classmethod
    def freeze(cls, output_file="requirements.txt", venv=False):
        try:
            result:subprocess.CompletedProcess|Any = Task.execute("pip", "freeze", capture_output=True, text=True, venv=venv)
            File(output_file).save(result.stdout, format="text")
        except Exception as e:
            raise Exception(e)
        
    @classmethod
    def check_updates(cls, venv=False):
        try:
            result:subprocess.CompletedProcess|Any = Task.execute("pip", "list", "--outdated", capture_output=True, text=True, venv=venv)
            return result.stdout
        except Exception as e:
            raise Exception(e)

    @classmethod        
    def execute(cls, *command, **kwargs):
        import os 
        shell = kwargs.get("shell", False)
        capture_output = kwargs.get("capture_output", False)
        text = kwargs.get("text", False) 
        check = kwargs.get("check", True)
        venv = kwargs.get("venv", False)

        executable = sys.executable
        if venv:
            if os.name == 'nt':
                python = Path.environment("python").join("Scripts\\python.exe").absolute() #type:ignore
            else:
                python = Path.environment("python").join("bin/python").absolute()
            if File(python).exists():
                executable=python.get()
        try:
            cmd = list(command)
            if not shell:
                cmd = [executable, '-m'] + cmd
            result: subprocess.CompletedProcess |Any= subprocess.run(cmd, shell=shell, check=check, capture_output=capture_output, text=text)
            if capture_output:
                return result
        except Exception as e:
            raise Exception(e)
    
    @classmethod
    def run(cls, source:str|Path, *filters, **kwargs):
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
         
    @classmethod
    def system_info(cls):
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
        

class Scheduler:

    def __init__(self, func, *args, **kwargs):
        self.func = func 
        self.args = args 
        self.kwargs = kwargs 
        self.interval:Any = None
        self.start_time = None
        self.end_time = None
        self.delay = None
        self.repeat = False 
        self.thread:Optional[threading.Thread] = None
        self.elapsed = 0
        self.executions = 0 
        self.paused = threading.Event()
        self.stoped = threading.Event() 
        # Callbacks
        self.on_start: Optional[Callable] = None
        self.on_update: Optional[Callable] = None
        self.on_pause: Optional[Callable] = None
        self.on_stop: Optional[Callable] = None

    def every(self, interval: float = 1): 
        self.interval = interval
        self.repeat = True 
        return self
    
    def seconds(self):
        return self

    def minutes(self):
        self.interval *= 60
        return self

    def hours(self):
        self.interval *= 3600
        return self

    def days(self):
        self.interval *= 86400
        return self
    
    def at(self, start, end=None): 
        def convert(time_str:str):
            parts = list(map(int, time_str.split(":")))
            while len(parts) < 4:
                parts.append(0)
            h, m, s, ms = parts
            now = datetime.now()
            period = now.replace(hour=h, minute=m, second=s, microsecond=ms)
            if period < now:
                period += timedelta(days=1)
            return period
        self.start_time = convert(start)
        if end:
            self.end_time = convert(end)
        return self
    
    def wait(self, seconds):
        self.delay = seconds 
        return self
    
    def run(self):
        self.func(*self.args, **self.kwargs)
        if self.on_update:self.on_update()
    
    def handler(self):
        start = time.time() 
        if self.start_time:
            while datetime.now() < self.start_time:
                if self.stoped.wait(0.5):
                    return
        if self.delay:
            time.sleep(self.delay)
        while not self.stoped.is_set(): 
            while self.paused.is_set():
                time.sleep(0.1)
            now = datetime.now()
            if self.end_time and now > self.end_time:
                break
            self.run()
            self.executions += 1
            if not self.repeat:
                break
            self.stoped.wait(timeout=self.interval)
        self.elapsed = time.time() - start

    def start(self):
        self.stoped.clear()
        if not self.is_running:
            self.thread = threading.Thread(target=self.handler, daemon=True)
            self.thread.start()
        if self.on_start:self.on_start()
        return self
    
    def pause(self):
        self.paused.set() 
        if self.on_pause: self.on_pause()

    def resume(self):
        self.paused.clear()
        
    def stop(self):
        self.stoped.set()
        if self.thread and self.thread.is_alive():
            self.thread.join()
        self.thread = None
        if self.on_stop:self.on_stop()
  
    def cancel(self): 
        self.stop()
        self.thread = None 
    
    def status(self):
        return {
            "running": self.is_running,
            "paused": self.is_paused,
            "executions": self.executions,
            "elapsed": self.elapsed,
            "interval": self.interval,
        }
    
    @property
    def is_running(self) -> bool:
        return self.thread is not None and self.thread.is_alive()

    @property
    def is_paused(self) -> bool:
        return self.paused.is_set()
