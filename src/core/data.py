import json
import configparser
import csv
import io
import base64
import pickle
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
    def __init__(self, content="", format="txt"):
        self.content = content
        self.format = format
        self.data = self.get()

    def get(self): 
        try:
            if self.format == 'json':
                return json.loads(self.content)
            elif self.format == 'xml':
                return ET.fromstring(self.content)
            elif self.format == 'yaml' and yaml:
                return yaml.safe_load(self.content)
            elif self.format == 'ini':
                config = configparser.ConfigParser()
                config.read_string(self.content)
                return config
            elif self.format == 'csv':
                f = io.StringIO(self.content)
                reader = csv.DictReader(f)
                return [row for row in reader]
            elif self.format == 'env':
                env = {}
                for line in self.content.splitlines():
                    if line and not line.startswith((';', '#')) and '=' in line:
                        key, value = line.strip().split('=', 1)
                        env[key] = value
                return env
            elif self.format == 'base64':
                return base64.b64decode(self.content)
            elif self.format == 'pickle':
                return pickle.loads(self.content if isinstance(self.content, bytes) else base64.b64decode(self.content))
            elif self.format == 'html':
                return unescape(self.content)
            elif self.format == 'markdown' and markdown:
                return markdown.markdown(self.content)
            elif self.format == 'pdf' and PyPDF2:
                reader = PyPDF2.PdfReader(io.BytesIO(self.content))
                return ''.join(page.extract_text() for page in reader.pages)
            elif self.format in ['jpg', 'jpeg', 'png', 'gif'] and Image:
                return Image.open(io.BytesIO(self.content))
            else:
                return self.content
        except Exception as e:
            raise Exception(f"Error loading data ({self.format}): {e}")

    def convert(self, format, **kwargs):  
        self.format = format
        try:
            if self.format == 'json':
                indent = kwargs.get('indent', None)
                return json.dumps(self.content, indent=indent)
            elif self.format == 'xml':
                root = ET.Element("root")
                for key, value in self.content.items():
                    child = ET.SubElement(root, key)
                    child.text = str(value)
                return ET.tostring(root, encoding='unicode')
            elif self.format == 'ini':
                config = configparser.ConfigParser()
                for section, values in self.content.items():
                    config[section] = values
                f = io.StringIO()
                config.write(f)
                return f.getvalue()
            elif self.format == 'csv':
                if not self.content:
                    return ""
                f = io.StringIO()
                writer = csv.DictWriter(f, fieldnames=self.content[0].keys())
                writer.writeheader()
                writer.writerows(self.content)
                return f.getvalue()
            elif self.format == 'yaml' and yaml:
                return yaml.dump(self.content, default_flow_style=False)
            elif self.format == 'env':
                groups = {}
                for key in sorted(self.content):
                    prefix = key.split('_')[0]
                    if prefix not in groups:
                        groups[prefix] = []
                    groups[prefix].append(f"{key}={str(self.content[key])}")
                return "\n\n".join("\n".join(groups[prefix]) for prefix in groups) + "\n"
            elif self.format == 'base64':
                if isinstance(self.content, str):
                    self.content = self.content.encode()
                return base64.b64encode(self.content).decode()
            elif self.format == 'pickle':
                raw = pickle.dumps(self.content)
                return base64.b64encode(raw).decode()
            elif self.format == 'html':
                return escape(str(self.content))
            elif self.format == 'markdown':
                return str(self.content)  # markdown is plaintext at this stage
            elif self.format == 'pdf':
                raise NotImplementedError("PDF export is not supported in-memory.")
            elif self.format in ['jpg', 'jpeg', 'png', 'gif'] and Image:
                buffer = io.BytesIO()
                img = Image.fromarray(self.content)
                img.save(buffer, format=self.format.upper())
                return buffer.getvalue()
            else:
                return str(self.content)
        except Exception as e:
            raise Exception(f"Error saving data ({self.format}): {e}")

    def __str__(self):
        return str(self.data)
