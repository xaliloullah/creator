class Color:
    BLACK = '\033[30m'
    RED = '\033[31m'
    GREEN = '\033[32m'
    YELLOW = '\033[33m'
    BLUE = '\033[34m'
    MAGENTA = '\033[35m'
    CYAN = '\033[36m'
    WHITE = '\033[37m'
    GREY = '\033[90m'
    LIGHT_BLACK = '\033[80m'
    LIGHT_RED = '\033[91m'
    LIGHT_GREEN = '\033[92m'
    LIGHT_YELLOW = '\033[93m'
    LIGHT_BLUE = '\033[94m'
    LIGHT_MAGENTA = '\033[95m'
    LIGHT_CYAN = '\033[96m'
    LIGHT_WHITE = '\033[97m'
            

    # Background colors
    BACKGROUND_BLACK = '\033[40m '
    BACKGROUND_RED = '\033[41m '
    BACKGROUND_GREEN = '\033[42m '
    BACKGROUND_YELLOW = '\033[43m '
    BACKGROUND_BLUE = '\033[44m '
    BACKGROUND_MAGENTA = '\033[45m '
    BACKGROUND_CYAN = '\033[46m '
    BACKGROUND_WHITE = '\033[47m '
    BACKGROUND_GREY = '\033[48m '
    BACKGROUND_LIGHT_BLACK = '\033[100m '
    BACKGROUND_LIGHT_RED = '\033[101m '
    BACKGROUND_LIGHT_GREEN = '\033[102m '
    BACKGROUND_LIGHT_YELLOW = '\033[103m '
    BACKGROUND_LIGHT_BLUE = '\033[104m '
    BACKGROUND_LIGHT_MAGENTA = '\033[105m '
    BACKGROUND_LIGHT_CYAN = '\033[106m '
    BACKGROUND_LIGHT_WHITE = '\033[107m '


    # color 
    @classmethod     
    def black(cls):
        return cls.BLACK
    
    @classmethod     
    def dark(cls):
        return cls.BLACK
    
    @classmethod 
    def red(cls):
        return cls.RED
    
    @classmethod 
    def green(cls):
        return cls.GREEN
    
    @classmethod 
    def yellow(cls):
        return cls.YELLOW
    
    @classmethod 
    def blue(cls):
        return cls.BLUE
    
    @classmethod 
    def magenta(cls):
        return cls.MAGENTA
    
    @classmethod 
    def cyan(cls):
        return cls.CYAN
    
    @classmethod 
    def white(cls):
        return cls.WHITE
    
    @classmethod 
    def grey(cls):
        return cls.GREY
    
    @classmethod 
    def light_black(cls):
        return cls.LIGHT_BLACK
    
    @classmethod 
    def light_red(cls):
        return cls.LIGHT_RED
    
    @classmethod 
    def light_green(cls):
        return cls.LIGHT_GREEN
    
    @classmethod 
    def light_yellow(cls):
        return cls.LIGHT_YELLOW
    
    @classmethod 
    def light_blue(cls):
        return cls.LIGHT_BLUE
    
    @classmethod 
    def light_magenta(cls):
        return cls.LIGHT_MAGENTA
    
    @classmethod 
    def light_cyan(cls):
        return cls.LIGHT_CYAN
    
    @classmethod 
    def light(cls):
        return cls.LIGHT_WHITE

    # BACKGROUND
    @classmethod     
    def bg_black(cls):
        return cls.BACKGROUND_BLACK
    
    @classmethod 
    def bg_red(cls):
        return cls.BACKGROUND_RED
    
    @classmethod 
    def bg_green(cls):
        return cls.BACKGROUND_GREEN
    
    @classmethod 
    def bg_yellow(cls):
        return cls.BACKGROUND_YELLOW
    
    @classmethod 
    def bg_blue(cls):
        return cls.BACKGROUND_BLUE
    
    @classmethod 
    def bg_magenta(cls):
        return cls.BACKGROUND_MAGENTA
    
    @classmethod 
    def bg_cyan(cls):
        return cls.BACKGROUND_CYAN
    
    @classmethod 
    def bg_white(cls):
        return cls.BACKGROUND_WHITE
    
    @classmethod 
    def bg_grey(cls):
        return cls.BACKGROUND_GREY
    
    @classmethod 
    def bg_light_black(cls):
        return cls.BACKGROUND_LIGHT_BLACK
    
    @classmethod 
    def bg_light_red(cls):
        return cls.BACKGROUND_LIGHT_RED
    
    @classmethod 
    def bg_light_green(cls):
        return cls.BACKGROUND_LIGHT_GREEN
    
    @classmethod 
    def bg_light_yellow(cls):
        return cls.BACKGROUND_LIGHT_YELLOW
    
    @classmethod 
    def bg_light_blue(cls):
        return cls.BACKGROUND_LIGHT_BLUE
    
    @classmethod 
    def bg_light_magenta(cls):
        return cls.BACKGROUND_LIGHT_MAGENTA
    
    @classmethod 
    def bg_light_cyan(cls):
        return cls.BACKGROUND_LIGHT_CYAN
    
    @classmethod 
    def bg_light(cls):
        return cls.BACKGROUND_LIGHT_WHITE