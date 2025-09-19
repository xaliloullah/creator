import os
import json
import configparser
import csv
import zipfile
import tarfile
import xml.etree.ElementTree as ET

try:
    import yaml
except ImportError:
    yaml = None

try:
    from PIL import Image
except ImportError:
    Image = None

try:
    import PyPDF2
except ImportError:
    PyPDF2 = None

from src.core import Path

class File:
    def __init__(self, path=".", **kwargs):

        self.path = path if isinstance(path, Path) else Path(path) 
        self.format = kwargs.get('format', "txt")
        self.mode = kwargs.get("mode", "r")
        self.content = kwargs.get("content", None) 
        self.encoding = kwargs.get("encoding", 'utf-8') 

        # if not self.format:
        #     self.format = self.file.get_extension(with_dot=False) 

    @property
    def name(self):
        return self.path.name() 
    
    @property
    def basename(self):
        return self.path.basename() 

    @property
    def extension(self):
        return self.path.extension(with_dot=True) 

    def read(self):
        with open(self.path, self.mode, self.encoding) as file:
            self.content = file.read()
        return self.content

    def load(self, **kwargs):
        try:
            mode = kwargs.get("mode", "r")
            format = kwargs.get('format', "txt")

            with open(self.path, mode, encoding='utf-8') as file:
                content = file.read()

                if format == 'json':
                    return json.loads(content) if content else {}
                elif format == 'xml':
                    return ET.fromstring(content)
                elif format == 'yaml' and yaml:
                    return yaml.safe_load(content)
                elif format == 'ini':
                    config = configparser.ConfigParser()
                    config.read_string(content)
                    return config
                elif format == 'csv':
                    file.seek(0)
                    reader = csv.DictReader(file)
                    return [row for row in reader]
                elif format == 'zip':
                    with zipfile.ZipFile(self.path, mode) as zip_ref:
                        zip_ref.extractall('_temp')
                        return zip_ref.namelist()
                elif format in ['tar', 'tar.gz', 'tgz']:
                    with tarfile.open(self.path, 'r:gz') as tar:
                        tar.extractall('_temp')
                        return tar.getnames()
                elif format in ['jpg', 'jpeg', 'png', 'gif'] and Image:
                    image = Image.open(self.path)
                    image.show()
                elif format == 'pdf' and PyPDF2:
                    with open(self.path, 'rb') as file:
                        reader = PyPDF2.PdfReader(file)
                        return ''.join(page.extract_text() for page in reader.pages)
                elif format == 'env':
                    env = {}
                    with open(self.path, mode) as file:
                        for line in file:
                            if line and not line.startswith((';', '#')) and '=' in line:
                                key, value = line.strip().split('=', 1)
                                env[key] = value
                    return env
                else:
                    return str(content)
        except Exception as e:
            raise Exception(f"Error loading file: {e}")

    def save(self, content=None, **kwargs):
        self.path.ensure_exists()
        mode = kwargs.get("mode", "w")
        format = kwargs.get('format', "txt")
        encoding = kwargs.get("encoding", "utf-8")

        try:
            if format == 'json':
                indent = kwargs.get('indent', None)
                with open(self.path, mode) as file:
                    json.dump(content, file, indent=indent)
            elif format == 'xml':
                root = ET.Element("root")
                for key, value in content.items():
                    child = ET.SubElement(root, key)
                    child.text = str(value)
                tree = ET.ElementTree(root)
                tree.write(self.path)
            elif format == 'yaml' and yaml:
                with open(self.path, mode) as file:
                    yaml.dump(content, file, default_flow_style=False)
            elif format == 'ini':
                config = configparser.ConfigParser()
                for section, values in content.items():
                    config[section] = values
                with open(self.path, mode, encoding=encoding) as file:
                    config.write(file)
            elif format == 'csv':
                with open(self.path, mode, encoding=encoding, newline='') as file:
                    writer = csv.DictWriter(file, fieldnames=content[0].keys())
                    writer.writeheader()
                    writer.writerows(content)
            elif format == 'zip':
                endswith = kwargs.get("endswith", None)
                ignore = kwargs.get("ignore", [])
                only = kwargs.get("only", [])
                with zipfile.ZipFile(content, 'w', zipfile.ZIP_DEFLATED) as zipf:
                    for root, dirs, files in self.walk_path(ignore=ignore, endswith=endswith, only=only):
                        for file in files:
                            file_path = Path(root).join(file).get()
                            zipf.write(file_path, os.path.relpath(file_path, self.path))
            elif format in ['tar', 'tar.gz', 'tgz']:
                with tarfile.open(self.path, 'w:gz') as tar:
                    for file_name in content:
                        tar.add(file_name)
            elif format in ['jpg', 'jpeg', 'png', 'gif'] and Image:
                image = Image.fromarray(content)
                image.save(self.path)
            elif format == 'pdf' and PyPDF2:
                with open(self.path, 'wb') as file:
                    writer = PyPDF2.PdfWriter()
                    file.write(writer)
            elif format == 'env':
                groups = {}
                for key in sorted(content):
                    prefix = key.split('_')[0]
                    if prefix not in groups:
                        groups[prefix] = []
                    groups[prefix].append(f"{key}={str(content[key])}")
                env = "\n\n".join("\n".join(groups[prefix]) for prefix in groups)
                with open(self.path, mode, encoding=encoding) as f:
                    f.write(f"{env}\n")
            else:
                with open(self.path, mode, encoding=encoding) as f:
                    f.write(f"{content}")
        except Exception as e:
            raise Exception(e)

    def delete(self):
        if self.path.is_dir():
            import shutil
            shutil.rmtree(self.path)
        elif self.path.is_file():
            os.remove(self.path) 
        
    def copy(self, destination, **kwargs):
        import shutil
        ignore = kwargs.get("ignore", [])
        only = kwargs.get("only", [])

        def ignore_items(src, names):
            if only:
                return [item for item in names if item not in only]
            return [item for item in names if item in ignore]

        shutil.copytree(self.path, destination, ignore=ignore_items, dirs_exist_ok=True)

    def move(self, target):
        import shutil
        target = Path(target)
        shutil.move(self.path, target)
        self.path.set(target)
        return self

    def rename(self, name): 
        self.path.rename(name)
        return self
    
    def touch(self): 
        self.path.make()
        return self

    def chmod(self, mode): 
        os.chmod(self.path, mode)
        return self

    def size(self): 
        if self.exists():
            return os.path.getsize(self.path)
        return 0
    
    def walk_path(self, **kwargs):
        endswith = kwargs.get("endswith", None)
        ignore = kwargs.get("ignore", [])
        only = kwargs.get("only", [])
        topdown = kwargs.get("topdown", True)

        for root, dirs, files in os.walk(self.path, topdown=topdown):
            if only:
                dirs[:] = [d for d in dirs if d in only]
                files = [f for f in files if f in only]
                only = False
            dirs[:] = [d for d in dirs if d not in ignore]
            files = [f for f in files if f not in ignore]
            if endswith:
                files = [f for f in files if f.endswith(endswith)]
            yield root, dirs, files

    def clean(self, cleans='__pycache__'):
        for root, dirs, files in self.walk_path(topdown=False):
            for name in dirs:
                if name == cleans:
                    path = Path(root).join(name).get()
                    File(path).delete()

    def list(self, **kwargs):
        endswith = kwargs.get("endswith", None)
        ignore = kwargs.get("ignore", [])
        files = os.listdir(self.path)
        if endswith:
            files = [f for f in files if f.endswith(endswith)]
        return [f for f in files if f not in ignore]

    def exists(self):
        return self.path.exists()
    
    def ensure_exists(self, folder=False):
        self.path.ensure_exists(folder)
        return self

    @staticmethod
    def make_structure(path=".", level=0, prefix="", **kwargs):
        try:
            ignore = kwargs.get("ignore", [])
            elements = File(path).list(ignore=ignore)
            structure = ""
            for index, element in enumerate(elements):
                folder = Path(path).join(element)
                if index == len(elements) - 1:
                    new_prefix = prefix + "    "
                    structure += f"{prefix}└── {element}\n"
                else:
                    new_prefix = prefix + "│   "
                    structure += f"{prefix}├── {element}\n"
                if Path(folder).is_dir():
                    structure += File.make_structure(folder, level + 1, new_prefix, ignore=ignore)
            return structure
        except Exception as e:
            raise Exception(e)
        
    def get_extension(self, **kwargs):
        return self.path.extension(**kwargs)
 
    def set_extension(self, extension: str) -> str:  
        if not extension.startswith("."):
            extension = "." + extension 
        dot_index = self.path.get().rfind(".")

        if dot_index == -1 or "/" in self.path.get()[dot_index:] or "\\" in self.path.get()[dot_index:]: 
            self.path = Path(self.path.get(), suffix=extension)
        else: 
            self.path = Path(self.path.get()[:dot_index], suffix=extension)
        return self

    def is_dir(self):
        return self.path.is_dir()

    def convert(self, format, output=None, **kwargs):
        content = self.load() 
        if output:
            File(output).save(content, format=format)
        else:
            self.set_extension(format).save(content, format=format)
