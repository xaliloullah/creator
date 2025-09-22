import os  
from .icons import Icon
from .colors import Color 
from .fonts import Font 
from .animation import Animation 

class Terminal:   
    width = 100  
    color = Color
    icon = Icon
    font = Font 

    # -----------------------------------------------------
    @classmethod    
    def print(cls, *contents, **kwargs):
        color: str = kwargs.get("color")
        icon: str = kwargs.get("icon")
        fonts: str = kwargs.get("font")
        margin: str = kwargs.get("margin")
        end: str = kwargs.get("end", "\n")
        flush: bool = kwargs.get("flush", False)  
        content = "".join(str(content) for content in contents)

        styled = []
        if fonts: 
            for font in fonts.split(","): 
                if getattr(Font, font.strip(), None):
                    styled.append(getattr(Font, font.strip(), None))
        if color and getattr(Color, color, None):
            styled.append(getattr(Color, color, None))
        if styled:
            content = cls.style(content, *styled) 
        if icon and getattr(Icon, icon, None):
            content = f"{getattr(Icon, icon, None)()} {content}"

        if margin:
            content = cls.margin(content, margin) 
        print(content, end=end, flush=flush)
        return cls

    @classmethod
    def success(cls, text):
        cls.SUCCESS = f"{Icon.light_check()} {cls.style('[SUCCESS] : ', Font.bold)}"
        cls.print(f"{cls.style(cls.SUCCESS, Color.green)}{cls.style(text, Color.green)}")

    @classmethod 
    def error(cls, text):
        cls.ERROR = f"{Icon.light_error()} {cls.style('[ERROR] : ', Font.bold)}"
        cls.print(f"{cls.style(cls.ERROR, Color.light_red)}{cls.style(text, Color.light_red)}")
    
    @classmethod 
    def info(cls, text):
        cls.INFO = f"{Icon.info_circle()}{cls.style('[INFO] : ', Font.bold)}"
        cls.print(f"{cls.style(cls.INFO, Color.blue)}{cls.style(text, Color.light)}")
    
    @classmethod      
    def warning(cls, text):
        cls.WARNING = f"{Icon.warning()}  {cls.style('[WARNING] : ', Font.bold)}"
        cls.print(f"{cls.style(cls.WARNING, Color.yellow)}{cls.style(text, Color.yellow)}")
    
    @classmethod 
    def danger(cls, text):
        cls.CRITICAL = f"{Icon.stop()} {cls.style('[CRITICAL] : ', Font.bold)}"
        cls.print(f"{cls.style(cls.CRITICAL, Color.red)}{cls.style(text, Color.red)}")

    @classmethod      
    def debug(cls, text):
        cls.DEBUG = f"{Icon.lightbulb()} {cls.style('[DEBUG] : ', Font.bold)}"
        cls.print(f"{cls.style(cls.DEBUG, Color.black)}{cls.style(text, Color.light)}")
    
    @classmethod      
    def help(cls, text):
        cls.HELP = f"{Icon.lightbulb()} {cls.style('[HELP] : ', Font.bold)}" 
        cls.print(f"{cls.style(cls.HELP, Color.cyan)}{cls.style(text, Color.cyan)}")
            
    @classmethod      
    def comment(cls, text):
        cls.COMMENT = f"{Icon.info()}  "
        cls.print(f"{cls.style(cls.COMMENT, Color.light)}{cls.style(text, Color.black)}")
    
    @classmethod      
    def description(cls, text):
        cls.print(f"{cls.style(text, Color.black, Font.italic)}")
    
    @classmethod 
    def question(cls, text):
        cls.QUESTION = f"{cls.style(': ', Font.bold)}{Icon.question()}" 
        cls.print(f"{cls.style(text, Color.light)} {cls.style(cls.QUESTION, Color.grey)}")
    
    @classmethod 
    def highlight(cls, text):
        cls.print(f"{cls.style(text, Font.bold, Color.yellow)}")
    
    @classmethod 
    def muted(cls, text):
        cls.print(f"{cls.style(text, Color.grey)}")
    
    @classmethod 
    def emphasize(cls, text):
        cls.print(f"{cls.style(text, Font.italic, Color.green)}")
    
    @classmethod 
    def title(cls, text: str, **kwargs):
        icon = kwargs.get('icon', Icon.border())
        width = kwargs.get('width', cls.width) 
        border = icon * width 
        cls.print(f"{cls.style(border, Font.bold, Color.light)}")
        cls.print(f"{cls.style(cls.uppercase(text).center(width), Font.bold, Color.light)}")
        cls.print(f"{cls.style(border, Font.bold, Color.light)}")
 
    @classmethod
    def subtitle(cls, text: str, **kwargs):
        icon = kwargs.get('icon', Icon.light_star())
        width = kwargs.get('width', cls.width)
        cls.print(f"{cls.style(text.center(width, icon), Font.bold, Color.grey, Font.underline)}")
    
    @classmethod      
    def label(cls, text):
        cls.print(cls.style(text, Color.light))
    
    @classmethod      
    def quote(cls, text, author="Unknown"):
        cls.print(f"{cls.style('“', Color.magenta)}{cls.style(text,Color.grey, Font.italic)}{cls.style('”', Color.magenta)} - {cls.style(author, Color.light, Font.underline)}")

    @classmethod
    def banner(cls, text:str,  **kwargs): 
        icon = kwargs.get('icon', Icon.light_star())
        width = kwargs.get('width', cls.width) 
        border = icon * width 
        cls.print(cls.style(border, Font.bold, Color.light))
        cls.print(cls.style(text.center(width), Font.bold, Color.light))
        cls.print(cls.style(border, Font.bold, Color.light))
    
    @classmethod      
    def style(cls, text:str, *styles): 
        styles = [style() if callable(style) else str(style) for style in styles] 
        return f"{''.join(styles)}{text}{Font.reset()}"
    
    @classmethod
    def margin(cls, content: str, margin: str): 
        if margin:
            left = top = right = bottom = 0
            parts = [int(part) for part in margin.split(",")] 
            if len(parts) > 0: left = parts[0]
            if len(parts) > 1: top = parts[1]
            if len(parts) > 2: right = parts[2]
            if len(parts) > 3: bottom = parts[3] 
            content = "\n" * top + content 
            lines = content.splitlines()
            lines = [f"{' ' * left}{line}{' ' * right}" for line in lines]
            content = "\n".join(lines) 
            content += "\n" * bottom
        return content

    @classmethod
    def clear(cls):
        os.system('cls' if os.name == 'nt' else 'clear')
    
    @classmethod      
    def uppercase(cls, text:str):
        return text.upper()
    
    @classmethod 
    def lowercase(cls, text:str):
        return text.lower() 
    
    @classmethod     
    def center(cls, text:str, width=width):
        cls.print(f"{cls.style(text.center(width), Font.bold)}") 
   
    @staticmethod
    def keyboard(attribute='name'):
        try:
            import keyboard
        except:
            keyboard=None
        while True:
            event = keyboard.read_event()
            if event.event_type == 'down':
                if attribute == 'name':
                    return event.name
                elif attribute == 'code':
                    return event.scan_code
                elif attribute == 'type':
                    return event.event_type
                elif attribute == 'time':
                    return event.time
                elif attribute == 'all':
                    return event
                else:
                    raise ValueError(
                        "attribute doit être 'name', 'code', 'type' ou 'time'"
                    )         

    @classmethod
    def box(cls, text, **kwargs): 
        border = kwargs.get("border", "single")
        color = kwargs.get("color", Color.light)
        padding = kwargs.get("padding", 1)
        width = kwargs.get("width", cls.width)

        borders = {
            "single": {"h": "─", "v": "│", "tl": "┌", "tr": "┐", "bl": "└", "br": "┘"},
            "double": {"h": "═", "v": "║", "tl": "╔", "tr": "╗", "bl": "╚", "br": "╝"},
            "rounded": {"h": "─", "v": "│", "tl": "╭", "tr": "╮", "bl": "╰", "br": "╯"},
            "bold": {"h": "━", "v": "┃", "tl": "┏", "tr": "┓", "bl": "┗", "br": "┛"},
            "ascii": {"h": "-", "v": "|", "tl": "+", "tr": "+", "bl": "+", "br": "+"},
            "block": {"h": "█", "v": "█", "tl": "█", "tr": "█", "bl": "█", "br": "█"}, 
            "dot": {"h": "┈", "v": "┊", "tl": "┌", "tr": "┐", "bl": "└", "br": "┘"},
            "dash": {"h": "╌", "v": "╎", "tl": "┌", "tr": "┐", "bl": "└", "br": "┘"},
            "light_double": {"h": "─", "v": "│", "tl": "╓", "tr": "╖", "bl": "╙", "br": "╜"},
            "heavy_double": {"h": "═", "v": "║", "tl": "╒", "tr": "╕", "bl": "╘", "br": "╛"},
            "none": {"h": " ", "v": " ", "tl": " ", "tr": " ", "bl": " ", "br": " "},
        }

        style = borders.get(border, borders["single"])
 
        if isinstance(text, str):
            lines = text.splitlines()
        else:
            lines = list(text)

        content_width = max(len(line) for line in lines)
        box_width = min(content_width + padding * 2, width)

        def pad(line):
            inner = line.ljust(box_width - padding * 2)
            return f"{style['v']}{' ' * padding}{inner}{' ' * padding}{style['v']}"

        top = f"{style['tl']}{style['h'] * box_width}{style['tr']}"
        bottom = f"{style['bl']}{style['h'] * box_width}{style['br']}"

        cls.print(cls.style(top, color))
        for line in lines:
            cls.print(cls.style(pad(line), color))
        cls.print(cls.style(bottom, color))

        for _ in range(bottom):
            content+="\n"
        return content

    @classmethod          
    def limit(cls, text, length=30, suffix="..."):
        if len(text) > length:
            cls.print(cls.style(text[:length] + suffix, Color.light))
        else:
            cls.print(cls.style(text, Color.light)) 

    @classmethod 
    def wrap(cls, text, width=width):
        import textwrap
        text = textwrap.fill(text, width)
        return text

    @classmethod
    def table(cls, data, **kwargs):
        if not data:
            return cls.warning("Empty") 
        if isinstance(data, dict):
            keys = kwargs.get('keys', list(data.keys()))
            data = [data]
        else:
            keys = kwargs.get('keys', None)

        data = list(data)
        margin = kwargs.get('margin', 3)
        icon = kwargs.get('icon', "-")
        color_header = kwargs.get('color_header', Color.grey)
        color_rows = kwargs.get('color_rows', Color.light)
        color_border = kwargs.get('color_border', Color.grey)
        display = kwargs.get('display', True) 
        head = keys if keys else data[0].keys() 
        def safe(val):
            return "" if val is None else str(val) 
        width = {
            key: max(len(str(key)), max(len(safe(row.get(key))) for row in data)) + margin
            for key in head
        }
        def border():
            return cls.style(icon * (sum(width.values()) + len(width) - (1 + margin)), color_border)
        # Header
        header = cls.style(
            " ".join([f"{key:<{width[key]}}" for key in head]),
            color_header,
            Font.bold
        )
        # Body
        body = "\n".join(
            cls.style(
                " ".join([f"{safe(row.get(key, '')):<{width[key]}}" for key in head]),
                color_rows
            )
            for row in data
        )
        table = f"{header}\n{border()}\n{body}\n{border()}"
        if display:
            cls.print(header)
            cls.print(border())
            for row in data:
                cls.print(
                    cls.style(
                        " ".join([f"{safe(row.get(key, '')):<{width[key]}}" for key in head]),
                        color_rows
                    )
                )
            cls.print(border())
        else:
            return table

    @classmethod
    def list(cls, data, **kwargs): 
        margin = kwargs.get('margin', 0)
        icon = kwargs.get('icon', "")
        color = kwargs.get('color', Color.grey)
        numbered = kwargs.get('numbered', False)
        inline = kwargs.get('inline', False)
        separator:str = kwargs.get('separator', "")
        display = kwargs.get('display', False)
    
        if not data:
            return cls.warning("Empty...")  
        if isinstance(data, dict):
            items = []
            for key, value in data.items():
                if value: 
                    items.append(f"{cls.style(str(key), color)}: {cls.style(str(value), Color.light)}")
                else:
                    items.append(cls.style(str(key), color))
            data = items
        else:
            data = list(data)

        lists = []
        if numbered:
            for index, item in enumerate(data, start=1):
                lists.append(f"{index:<{margin}}. {item}")
        else:
            for item in data:
                lists.append(f"{icon:<{margin}}{item}")

        if inline:
            Fontted = cls.style(separator.join(lists), color)
        else:
            Fontted = "\n".join([cls.style(item, color) + f"{cls.style(separator, Color.black)}" for item in lists])
        
        if display:
            cls.print(Fontted)
        else:
            return Fontted 
        
    @classmethod
    def textarea(cls, placeholder="textarea: ", end="\n"):
        print(placeholder, end='', flush=True)
        textarea = []
        while True:
            text = input()
            if text == "":
                if textarea and textarea[-1] == "":
                    break
                else:
                    textarea.append("")
            else:
                textarea.append(text)
                    
        output = end.join(textarea)
        if output.endswith(end):
            output = output[:-len(end)]
        return output

    @classmethod      
    def password(cls, prompt="password : ", **kwargs):
        try:
            cls.print(prompt, end='', flush=True)
            import getpass
            return getpass.getpass('')
        except (KeyboardInterrupt, EOFError): 
            return None

    @classmethod 
    def input(cls, placeholder="", **kwargs):  
        value = kwargs.get('value', "")     
        options:dict = kwargs.get('options', {})     
        choices = ""    
        type = kwargs.get('type', 'text')  
        min_len = kwargs.get('min_len', None)  
        max_len = kwargs.get('max_len', None)  
        min = kwargs.get('min', None)  
        max = kwargs.get('max', None)  
        required = kwargs.get('required', False)      
        accept:str = kwargs.get('accept', 'yes')
        accept_action = kwargs.get('accept_action', None)
        reject:str = kwargs.get('reject', 'no') 
        reject_action = kwargs.get('reject_action', None) 
        prompt = kwargs.get("prompt", ": ")

        action = input
        icon = Icon.arrow_right()

        if type =="email":
            icon = Icon.enveloppe()

        elif type == "password": 
            icon = Icon.lock()
            action = cls.password
            
        elif type in ("tel", "phone"):
            icon = Icon.phone()
            
        elif type == "address":
            icon = Icon.location()
            
        elif type == "url":
            icon = Icon.globe()
            
        elif type == "search":
            icon = Icon.search()
            
        elif type in ("date", "datetime", "time"):
            icon = Icon.calendar()
            
        elif type in ("number", "integer", "float", "decimal"):
            icon = Icon.number()
            
        elif type in ("textarea", "message"):
            icon = Icon.file()
            action = cls.textarea

        elif type in ("select", "option"):
            icon = Icon.arrow_down() 
        
        elif type in ("confirmation", "confirm", "checkbox", 'dialog'):  
            icon = f"{Icon.check()}|{Icon.error()}"
            options = {accept:"", reject:""}

        if value: 
            default = f"[{cls.style(value, Color.grey)}]"
        else: default = ""

        if options:  
            separator = kwargs.get("separator", " ")
            choices = f"\n{cls.list(options, separator=separator)}\n"

        result = action(f"{cls.style(f"{icon} {placeholder}{choices}{default}{prompt}", Color.light)}") or value  

        if required:
            while not result:
                cls.warning("This field is required.")
                return cls.input(placeholder, **kwargs)
        if max_len:
            if len(str(result)) > max_len:
                cls.warning(f"Input exceeds maximum length of {max_len} characters.")
                return cls.input(placeholder, **kwargs)
        if min_len:
            if len(str(result)) < min_len:
                cls.warning(f"Input is below the minimum length of {min_len} characters.")
                return cls.input(placeholder, **kwargs) 
        if min:
            if float(result) < float(min):
                cls.warning(f"Input is below the minimum value of {min}.")
                return cls.input(placeholder, **kwargs)
        if max:
            if float(result) > float(max):
                cls.warning(f"Input exceeds the maximum value of {max}.")
                return cls.input(placeholder, **kwargs)
        if options:
            if result not in options:
                cls.warning(f"Please enter one of the following options: {', '.join(options)}.")
                return cls.input(placeholder, **kwargs) 
            if result.lower() == accept.lower():
                if accept_action:
                    accept_action()
                return True
            elif result.lower() == reject.lower():
                if reject_action:
                    reject_action()
                return False
        return result
    
    @classmethod
    def animation(cls, **kwargs): 
        return Animation(**kwargs)