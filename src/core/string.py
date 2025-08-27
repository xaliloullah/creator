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

    def camelcase(self): 
        return String("".join(word.capitalize() for word in self.split()))

    def snakecase(self): 
        text = re.sub(r"[\W_]+", "_", self.lower())
        return String(text.strip("_"))

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
     