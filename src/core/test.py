import time
from src.core import File, Path, Task, String
from src.console import Terminal

class Test:
    path = Path.tests()
    file = File(path)
    results = []


    def __init__(self, name:str):
        self.name = name

    def run(self):
        path = Path(self.path).join(self.name)
        Terminal.title(f"Running test: {self.name.replace('.py', '')}")
        start_time = time.time()
        success = False 
        error = ""
        animation = Terminal.animation() 
        thread = Task.do(animation.progress, message=f"Running test: {self.name.replace('.py', '')}").start()
        try:
            Task.run(path, 'test_*') 
            success = True
        except Exception as e:
            success = False 
            error = e 
        finally: 
            animation.stop()
            thread.stop() 
            if success:
                Terminal.success(f"Test succeeded: {path}")
            else:

                Terminal.error(f"Error running test: {path} - {error}")
            Terminal.info(f"Duration: {thread.elapsed:.2f}s") 
            self.results.append({
                "name": self.name,
                "success": success,
                "duration": thread.elapsed
            })

    @classmethod
    def execute(cls):
        tests = cls.get()
        for test in tests:
            cls(test).run() 
        cls.report()


    @classmethod
    def get(cls, name=None):
        try:
            tests = cls.file.list(endswith=".py")
            if name:
                name = Path(String(name).snakecase(), suffix=".py").get()
                return name
            return sorted(tests)
        except Exception as e:
            Terminal.error(f"{e}")
            exit(1)

    @classmethod
    def report(cls):
        total = len(cls.results)
        success_count = sum(1 for result in cls.results if result["success"])
        fail_count = total - success_count
        success_rate = (success_count / total * 100) if total else 0
        fail_rate = (fail_count / total * 100) if total else 0
        total_time = sum(result["duration"] for result in cls.results)
        avg_time = total_time / total if total else 0

        Terminal.title("Test Report")
        Terminal.info(f"Total tests: {total}")
        Terminal.success(f"Pass : {success_count} ({success_rate:.2f}%)")
        Terminal.error(f"Failure : {fail_count} ({fail_rate:.2f}%)")
        Terminal.info(f"Total duration: {total_time:.2f}s")
        Terminal.info(f"Average duration per test: {avg_time:.2f}s") 