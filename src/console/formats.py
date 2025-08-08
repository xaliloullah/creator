class Format:
    BOLD = '\033[1m'         
    UNDERLINE = '\033[4m'     
    ITALIC = '\033[3m'        
    BLINK = '\033[5m'         
    REVERSE = '\033[7m'       
    HIDDEN = '\033[8m'        
    RESET = '\033[0m'


    @classmethod     
    def bold(cls):
        return cls.BOLD
    
    @classmethod     
    def underline(cls):
        return cls.UNDERLINE
    
    @classmethod     
    def italic(cls):
        return cls.ITALIC
    
    @classmethod     
    def blink(cls):
        return cls.BLINK
    
    @classmethod     
    def reverse(cls):
        return cls.REVERSE
    
    @classmethod     
    def hidden(cls):
        return cls.HIDDEN
    
    @classmethod     
    def reset(cls):
        return cls.RESET