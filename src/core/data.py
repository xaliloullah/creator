import json
import configparser
import csv
import io
import base64
import pickle
import re
from typing import Any
import xml.etree.ElementTree as ET
from html import escape, unescape

try:
    import yaml
except ImportError:
    yaml = None

try:
    import markdown
except ImportError:
    markdown = None

try:
    import PyPDF2
except ImportError:
    PyPDF2 = None

try:
    from PIL import Image
except ImportError:
    Image = None


class Data:
    def __init__(self, content:Any, format="txt"):
        self.content = content
        self.format = format 
        self.data:Any = None
        try:
            if self.format == 'json':
                self.data = json.loads(self.content)
            elif self.format == 'xml':
                self.data = ET.fromstring(self.content)
            elif self.format == 'yaml' and yaml:
                self.data = yaml.safe_load(self.content)
            elif self.format == 'ini':
                config = configparser.ConfigParser()
                config.read_string(self.content)
                self.data = config
            elif self.format == 'csv':
                f = io.StringIO(self.content)
                reader = csv.DictReader(f)
                self.data = [row for row in reader]

            elif self.format == 'env':
                env = {}
                for line in self.content.splitlines():
                    if line and not line.startswith((';', '#')) and '=' in line:
                        key, value = line.strip().split('=', 1)
                        env[key] = value
                self.data = env

            elif self.format == 'base64':
                self.data = base64.b64decode(self.content)
            elif self.format == 'pickle':
                self.data = pickle.loads(self.content if isinstance(self.content, bytes) else base64.b64decode(self.content))
            elif self.format == 'html':
                self.data = unescape(self.content)
            elif self.format == 'markdown' and markdown:
                self.data = markdown.markdown(self.content)
            elif self.format == 'pdf' and PyPDF2:
                reader = PyPDF2.PdfReader(io.BytesIO(self.content))
                self.data = ''.join(page.extract_text() for page in reader.pages)
            elif self.format in ['jpg', 'jpeg', 'png', 'gif'] and Image:
                self.data = Image.open(io.BytesIO(self.content))
            else:
                self.data = self.content
        except Exception as e:
            raise Exception(f"Error loading data ({self.format}): {e}")
        
    def get(self): 
        return self.data
    
    def convert(self, format, **kwargs):  
        self.format = format
        try:
            if self.format == 'json':
                indent = kwargs.get('indent', None)
                return json.dumps(self.data, indent=indent)
            elif self.format == 'xml':
                root = ET.Element("root")
                for key, value in self.data.items():
                    child = ET.SubElement(root, key)
                    child.text = str(value)
                return ET.tostring(root, encoding='unicode')
            elif self.format == 'ini':
                config = configparser.ConfigParser()
                for section, values in self.data.items():
                    config[section] = values
                f = io.StringIO()
                config.write(f)
                return f.getvalue()
            elif self.format == 'csv':
                if not self.data:
                    return ""
                f = io.StringIO()
                writer = csv.DictWriter(f, fieldnames=self.data[0].keys())
                writer.writeheader()
                writer.writerows(self.data)
                return f.getvalue()
            elif self.format == 'yaml' and yaml:
                return yaml.dump(self.data, default_flow_style=False)
            elif self.format == 'env':
                groups = {}
                for key in sorted(self.data):
                    prefix = key.split('_')[0]
                    if prefix not in groups:
                        groups[prefix] = []
                    groups[prefix].append(f"{key}={str(self.data[key])}")
                return "\n\n".join("\n".join(groups[prefix]) for prefix in groups) + "\n"
            
            elif self.format == 'base64':
                if isinstance(self.data, str):
                    self.data = self.data.encode()
                return base64.b64encode(self.data).decode()
            elif self.format == 'pickle':
                raw = pickle.dumps(self.data)
                return base64.b64encode(raw).decode()
            elif self.format == 'html':
                return escape(str(self.data))
            elif self.format == 'markdown':
                return str(self.data)  # markdown is plaintext at this stage
            elif self.format == 'pdf':
                raise NotImplementedError("PDF export is not supported in-memory.")
            elif self.format in ['jpg', 'jpeg', 'png', 'gif'] and Image:
                buffer = io.BytesIO()
                img = Image.fromarray(self.data)
                img.save(buffer, format=self.format.upper())
                return buffer.getvalue()
            else:
                return str(self.data)
        except Exception as e:
            raise Exception(f"Error data ({self.format}): {e}")
         
    def is_html(self) -> bool:
        return bool(re.search(r"<[^>]+>", self.data))


    def __str__(self):
        return str(self.data)
