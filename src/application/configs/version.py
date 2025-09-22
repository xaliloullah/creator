class Version:
    def __init__(self, version:str=""):
        self.set(version) 

    def __str__(self): 
        return f"{self._major_}.{self._minor_}.{self._patch_}{f"-{self._suffix_}" if self._suffix_ else ""}"

    def major(self): 
        self._major_ += 1
        self._minor_ = 0
        self._patch_ = 0
        self._suffix_ = ''
        return self

    def minor(self): 
        self._minor_ += 1
        self._patch_ = 0
        self._suffix_ = ''
        return self

    def patch(self): 
        self._patch_ += 1
        self._suffix_ = ''
        return self
        
    def suffix(self, suffix): 
        self._suffix_ = suffix
        return self
     
    def get(self): 
        return str(self)
     
    def set(self, version:str): 
        try: 
            major, minor, patch = version.split(".")
            if "-" in patch:
                patch, suffix = patch.split("-")
                self._suffix_ = suffix
            else:
                self._suffix_ = ""
            self._major_ = int(major)
            self._minor_ = int(minor)
            self._patch_ = int(patch)
        except ValueError as e:
            raise ValueError(e)
 