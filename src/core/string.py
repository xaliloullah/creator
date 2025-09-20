import re

class String(str):
    
    def pluralize(self): 
        word = self.strip()
        if not word:
            return String(word) 
        if word.endswith(("s", "x", "z", "ch", "sh")):
            return String(word + "es")
        elif word.endswith("y") and word[-2].lower() not in "aeiou":
            return String(word[:-1] + "ies")
        else:
            return String(word + "s")
        
    def singularize(self):
        word = self.strip()
        if not word:
            return String(word) 
        if word.endswith("ies") and len(word) > 3:
            return String(word[:-3] + "y") 
        elif word.endswith("es") and (word[-3:-2] in ["s", "x", "z"] or word[-4:-2] in ["ch", "sh"]):
            return String(word[:-2]) 
        elif word.endswith("s") and len(word) > 1:
            return String(word[:-1])
        return String(word)

        
    def replace(self, old, new="", count=-1): 
        result = self
        if isinstance(old, (list, tuple, set)):
            for item in old:
                result = super().replace(item, new, count)
        else:
            result = super().replace(old, new, count)
        return String(result)
    
    def reverse(self): 
        return String(self[::-1])

    def is_palindrome(self): 
        s = self.lower().replace(" ", "")
        return s == s[::-1]

    def slugify(self, sep="-"):  
        text = self.lower()
        text = re.sub(r"[^a-z0-9]+", sep, text)
        text = re.sub(rf"{sep}+", sep, text).strip(sep)
        return String(text)
    
    def split_case(self):
        text = str(self) 
        text = re.sub(r'(?<=[a-z0-9])(?=[A-Z])', ' ', text) 
        text = re.sub(r'[_\W]+', ' ', text)
        return text.strip().split()


    def camelcase(self):
        words = self.split_case()
        if not words:
            return String("")
        first = words[0].lower()
        rest = "".join(word.capitalize() for word in words[1:])
        return String(first + rest)

    def pascalcase(self):
        words = self.split_case()
        return String("".join(word.capitalize() for word in words))

    def snakecase(self):
        words = self.split_case()
        return String("_".join(word.lower() for word in words))
    
    def kebabcase(self):
        words = self.split_case()
        return String("-".join(word.lower() for word in words))
    
    def dotcase(self):
        words = self.split_case()
        return String(".".join(word.lower() for word in words))

    def remove_spaces(self): 
        return String(self.replace(" ", ""))

    def words(self): 
        return [String(w) for w in self.split()]
    
    def limit(self, length, ellipsis="..."):
        if len(self) <= length:
            return String(self)
        return String(self[:length-len(ellipsis)] + ellipsis)
    

    def pad(self, length, char=" "):
        return String(self.ljust(length, char))
    
    def clean(self): 
        return String(re.sub(r"\s+", " ", self.strip()))
    
    def wrap(self, width=70):
        import textwrap 
        return [String(line) for line in textwrap.wrap(self, width)]
 
    def shuffle(self): 
        import random
        chars = list(self)
        random.shuffle(chars)
        return String("".join(chars)) 
    
    def contains(self, substring):
        return substring in self
    
    def add(self, text):
        return String(self+text) 