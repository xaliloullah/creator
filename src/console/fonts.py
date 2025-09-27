class Font:
    BOLD = '\033[1m'         
    UNDERLINE = '\033[4m'     
    ITALIC = '\033[3m'        
    BLINK = '\033[5m'         
    REVERSE = '\033[7m'       
    HIDDEN = '\033[8m'        
    RESET = '\033[0m'

    STRIKETHROUGH = '\033[9m'
    DOUBLE_UNDERLINE = '\033[21m'
    NORMAL_INTENSITY = '\033[22m'
    NO_ITALIC = '\033[23m'
    NO_UNDERLINE = '\033[24m'
    NO_BLINK = '\033[25m'
    NO_REVERSE = '\033[27m'
    NO_HIDDEN = '\033[28m'

    FRAKTUR = '\033[20m'       # Style gothique
    OVERLINE = '\033[53m'      # Ligne au-dessus du texte
    FRAME = '\033[51m'         # Cadre autour du texte
    ENCIRCLE = '\033[52m'      # Cercle autour du texte
    CURSOR_HIGHLIGHT = '\033[60m'  # Surlignage spécial

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