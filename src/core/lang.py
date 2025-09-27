from typing import Any
from src.core import File

class Lang:
    def __init__(self, lang):
        try:
            self.lang = lang 
            self.path = f"lang/{self.lang}/" 
            self.default = "en"
            self.data = self.load()
            self.languages = self.data["languages"]
        except (KeyError, FileNotFoundError) as e:
            raise ValueError(f"Invalid language or missing data: {lang}") from e
        
    def check(self, lang):
        if lang in self.languages:
            return True 
        return False
        
    def load(self, **kwargs):  
        retry = kwargs.get("retry", True)
        try:
            self.files = File(self.path).list()
            content = {}
            for file in self.files:
                content.update(File(f"{self.path}{file}").load(format="json")) 
            return content
        except Exception as e:
            
            if retry: 
                self.path = f"lang/{self.default}/"
                return self.load(retry=False)
            else:
                raise FileNotFoundError from e 
        
    def save(self, content):
        backup = self.load()
        try:
            File(self.path).save(content, format="json", indent=2)
        except Exception as e:
            File(self.path).save(backup, format="json", indent=2) 
            raise e

    def get_placeholders(self, text: str):
        import re 
        return re.findall(r'\{(.*?)\}', text)
    
    def resolve(self, args:Any|str, **kwargs):  
        placeholders = self.get_placeholders(args)
        for placeholder in placeholders:
            if placeholder in kwargs:
                args = args.replace(f"{{{placeholder}}}", str(kwargs[placeholder]))
        return args  
    
    def collect(self, *keys, **kwargs):
        default = kwargs.get("default", "")
        text = self.data.copy() 
        for key in keys:
            if key in text:
                text = text[key]
            else:
                return default
        return self.resolve(text, **kwargs)
    
    def get(self, key:str, **kwargs):
        keys = key.split(".")
        result = self.collect(*keys, **kwargs)
        return result
    
    def set(self, **kwargs):
        for key, value in kwargs.items():
            self.data[key] = value
        self.save(self.data)
    
    def translate(self, text:str, target=None, source="auto"):      
        from src.core import Translator
        if target:
            self.target = target
        else:
            self.target = self.lang
        self.source = source 
        translate:str = Translator.translate(text, self.target, source=self.source) 
        params = self.get_placeholders(text)
        if params:
            placeholders = self.get_placeholders(translate)
            for placeholder in placeholders:
                translate = translate.replace(f"{{{placeholder}}}", f"{{{params[placeholders.index(placeholder)]}}}")
        return translate
    
    def generate(self, lang): 
        targetination = self.path.replace(self.lang, lang) 
        for file in self.files:
            src_path = f"{self.path}{file}" 
            target_path = f"{targetination}{file}" 
            content = File(src_path).load(format="json")
            
            def deep_translate(content, lang):
                for text in content: 
                    if isinstance(content[text], dict):
                        content[text] = deep_translate(content[text], lang)
                    elif isinstance(content[text], str):
                        content[text] = self.translate(content[text], target=lang) 
                return content
            
            content = deep_translate(content, lang)
            File(target_path).save(content, format="json", indent=2) 
    
    def __setitem__(self, key, value):
        self.data[key] = value
    
    def __getitem__(self, key):
        return self.data[key]
    
    def __str__(self):
        return f"{self.lang}"
    
    def __repr__(self):
        return f"Lang({self.lang})"
    
    def __del__(self):
        del self
        
        
