import sys 
import ast

from .file import File
from .path import Path
from .task import Task

from src.console import Terminal

class Debug:  

    def __init__(self, *args, exit: bool = False, step: bool = False):
        if step:
            for arg in args:
                Terminal.debug(arg)
                input("Press Enter to continue...")
        else:
            Terminal.debug(*args)
        if exit:
            sys.exit(1)

    @classmethod
    def search(cls, target, path=".", display=True):
        results:list[dict] = []
        file = File(path)
        animation = Terminal.animation() 
        thread = Task.do(animation.loader, spinner="blocks", message=f"search {target} ...").start()
        for root, dirs, files in file.walk_path(endswith=".py", ignore=["python", "__pycache__"]):
            for file in files: 
                full_path = Path(root).join(file)
                try:
                    with open(full_path, encoding="utf-8") as f:
                        source = f.read()
                    tree = ast.parse(source, filename=full_path)
                except Exception:
                    continue

                lines = source.splitlines()

                for node in ast.walk(tree):
                    kind = None

                    kind = None

                    # Variables et noms simples
                    if isinstance(node, ast.Name) and node.id == target:
                        kind = "Name"

                    # Attributs (objets.methode ou objets.attribut)
                    elif isinstance(node, ast.Attribute) and node.attr == target:
                        kind = "Attribute" 
                    elif isinstance(node, ast.Call):
                        func = node.func
                        if isinstance(func, ast.Name) and func.id == target:
                            kind = "FunctionCall"
                        elif isinstance(func, ast.Attribute) and func.attr == target:
                            kind = "MethodCall" 
                    elif isinstance(node, ast.FunctionDef) and node.name == target:
                        kind = "FunctionDef" 
                    elif isinstance(node, ast.ClassDef) and node.name == target:
                        kind = "ClassDef" 
                    elif isinstance(node, ast.Assign):
                        for target_node in node.targets:
                            if isinstance(target_node, ast.Name) and target_node.id == target:
                                kind = "Assign" 
                    elif isinstance(node, ast.For):
                        if isinstance(node.target, ast.Name) and node.target.id == target:
                            kind = "ForLoop" 
                    elif isinstance(node, ast.If): 
                        if hasattr(node.test, 'id') and node.test.id == target: # type: ignore
                            kind = "If" 
                    elif isinstance(node, ast.Import):
                        for alias in node.names:
                            if alias.name == target:
                                kind = "Import"
                    elif isinstance(node, ast.ImportFrom):
                        for alias in node.names:
                            if alias.name == target:
                                kind = "ImportFrom"


                    if kind:
                        line = lines[node.lineno - 1].strip() # type: ignore
                        results.append({"file": str(full_path), "line": node.lineno, "col": node.col_offset, "kind": kind, "code": line # type: ignore
                        })
        animation.stop()
        thread.stop() 
        if results:
            if display:
                for result in results:
                    Terminal.print(f"{result.get("file", "")}:", color="green", end="").print(f"{result.get("line", "")}:{result.get("col", "")}", margin="0, 0, 1", end="").print(f"[{result.get("kind", "")}] -> ", color="red", margin="1, 0, 1", end="").print(f"{result.get("code", "")}")
            else:
                return results
        else:
            Terminal.print(f"No occurrences of '{target}' found.", color="yellow")