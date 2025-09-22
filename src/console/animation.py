import time
import random  

class Animation:
    
    def __init__(self, **kwargs):
        from .terminal import Terminal
        self.output = Terminal.print
        self.color = kwargs.get('color', "cyan")
        self.animate = False
     
    def start(self):
        self.animate = True
        return self
     
    def stop(self):
        self.animate = False
        return self
    
    def toggle(self):
        self.animate = not self.animate
        return self
 
    def writer(self, text, **kwargs):
        speed = kwargs.get('speed', 0.05)
        cursor = kwargs.get('cursor')
        for char in text:
            self.output(f"{char}{cursor}", end='', flush=True)
            time.sleep(speed)
            if cursor:
                self.output('\b', end='', flush=True)

        
    def loader(self, **kwargs): 
        step = kwargs.get('step', 1) 
        color = kwargs.get('color', self.color) 
        spinner = kwargs.get('spinner', 'bars') 
        message = kwargs.get('message', "") 
        delay = kwargs.get('delay', 0.1)
        spinners = { 
            'dots': ['.', '..', '...'],
            'flip': ['⠁','⠂','⠄','⠂'],
            'line': ['—', '–', '—', '–'],
            'bars': ['|', '/', '-', '\\'],
            'toggle': ['◍','◎','◉','◎'],
            'arrows': ['←', '↑', '→', '↓'],
            'pulse': ['∙','●','◌','●','∙'],
            'arcs': ['◜', '◝', '◞', '◟'],
            'cascade': ['⋮', '⋰', '⋯', '⋱'],
            'disque': ['◐', '◓', '◑', '◒'],
            'triangle': ['◢', '◣', '◤', '◥'],
            'fading': ['█','▓','▒','░','▒','▓'],
            'star': ['✶','✸','✹','✺','✹','✷'],
            'wave': ['⠁','⠂','⠄','⡀','⢀','⠠','⠐','⠈'],
            'blocks': ['▁', '▂', '▃', '▄', '▅', '▆', '▇', '█'],
            'grow': ['▁','▃','▄','▅','▆','▇','▆','▅','▄','▃'],
            'braille': ['⠋','⠙','⠚','⠞','⠖','⠦','⠴','⠲','⠳','⠓'],
            'earth': ['🌍', '🌎', '🌏'],
            'heart': [ '❤️', '🧡', '💛', '💚', '💙', '💜'],
            'circle': ['🔴', '🟠', '🟡', '🟢', '🔵', '🟣'],
            'square': ['🟥', '🟧', '🟨', '🟩', '🟦', '🟪'],
            'weather': ['☀️', '🌤️', '⛅', '🌥️', '☁️', '🌧️', '⛈️'],
            'moon': ['🌑', '🌒', '🌓', '🌔', '🌕', '🌖', '🌗', '🌘'],
            'clock': ['🕛', '🕐', '🕑', '🕒', '🕓', '🕔', '🕕', '🕖', '🕗', '🕘', '🕙', '🕚']
        }
        spinner = spinners.get(spinner, spinners['bars'])
        margin = max(len(symbol) for symbol in spinner)  
        progress = 0
        while self.animate:
            symbol = spinner[int(progress / step) % len(spinner)].ljust(margin) 
            self.output(f"\r{symbol} {message}", color=color, end="")
            time.sleep(delay)
            progress += step
        self.output()
 
    def progress(self, **kwargs): 
        step = kwargs.get('step', 10)
        color = kwargs.get('color', "cyan") 
        total = kwargs.get('total', 100)
        width = kwargs.get('width', 50)
        message = kwargs.get('message', "")
        delay = kwargs.get('delay', 0.5)
        step = max(1, min(step, total))

        def show(progress):  
            percent = (progress / total) * 100
            filled = int(width * progress / total)
            bar = '█' * filled + '░' * (width - filled)
            self.output(f"\r{bar} {percent:.0f}% {message}", color=color, end="") 

        progress = 0
        while progress < total:
            if self.animate:
                progress = min(progress + random.randint(1, step), total)
                time.sleep(random.uniform(0.1, delay))
            else:
                progress = total
            show(progress) 
        self.output()