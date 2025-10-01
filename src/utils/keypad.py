from typing import Any

class Keyboard:
    _keyboard = None
    _pressed = set()
    _names = {}
    _hook: Any = None

    KEY_A = (16, 57360)
    KEY_B = (48, 57392)
    KEY_C = (46, 57390)
    KEY_D = (32, 57376)
    KEY_E = (18,)      
    KEY_F = (33, 57377)
    KEY_G = (34, 57378)
    KEY_H = (35,)      
    KEY_I = (23,)      
    KEY_J = (36, 57380)
    KEY_K = (37,)      
    KEY_L = (38,)      
    KEY_M = (39,)      
    KEY_N = (49,)      
    KEY_O = (24,)      
    KEY_P = (25, 57369)
    KEY_Q = (30,)      
    KEY_R = (19,)      
    KEY_S = (31,)      
    KEY_T = (20,)      
    KEY_U = (22,)      
    KEY_V = (47,)      
    KEY_W = (44,)      
    KEY_X = (45,)      
    KEY_Y = (21,)      
    KEY_Z = (17,)      
    KEY_0 = (82, 11)   
    KEY_1 = (79, 2)    
    KEY_2 = (80, 3)    
    KEY_3 = (81, 4)    
    KEY_4 = (75, 5)    
    KEY_5 = (76, 6)    
    KEY_6 = (77, 7)    
    KEY_7 = (71, 8)    
    KEY_8 = (72, 9)    
    KEY_9 = (73, 10)   
    KEY_SPACE = (57,)  
    KEY_ENTER = (28,)  
    KEY_TAB = (15, 124)
    KEY_BACKSPACE = (14,)
    KEY_ESC = (1,)
    KEY_SHIFT = (42, 54)
    KEY_CTRL = (29, 57373)
    KEY_ALT = (56,)
    KEY_CAPS_LOCK = (58,)
    KEY_UP = (72,)
    KEY_DOWN = (80,)
    KEY_LEFT = (75,)
    KEY_RIGHT = (77,)
    KEY_INSERT = (82,)
    KEY_DELETE = (83,)
    KEY_HOME = (71,)
    KEY_END = (79,)
    KEY_PAGE_UP = (73,)
    KEY_PAGE_DOWN = (81,)
    KEY_F1 = (59,)
    KEY_F2 = (60,)
    KEY_F3 = (61,)
    KEY_F4 = (62,)
    KEY_F5 = (63,)
    KEY_F6 = (64,)
    KEY_F7 = (65,)
    KEY_F8 = (66,)
    KEY_F9 = (67,)
    KEY_F10 = (68,)
    KEY_F11 = (87,)
    KEY_F12 = (88,)



    @classmethod
    def init(cls):
        try:
            import keyboard
            cls._keyboard = keyboard
            if cls._hook is None:
                cls._hook = keyboard.hook(cls._handle_event)
        except ImportError:
            raise ImportError("Module 'keyboard' non installé. Faites: pip install keyboard")

    @classmethod
    def stop(cls):
        if cls._keyboard and cls._hook:
            cls._keyboard.unhook(cls._hook)
        cls._hook = None
        cls._pressed.clear()
        cls._names.clear()

    @classmethod
    def _handle_event(cls, event):
        code = getattr(event, "scan_code", None)
        if code is None:
            return
        name = str(getattr(event, "name", code)).lower()
        if event.event_type == "down":
            cls._pressed.add(code)
            cls._names[code] = name
        else:
            cls._pressed.discard(code)
            cls._names.pop(code, None)

    @classmethod
    def is_pressed(cls, key):
        if cls._keyboard is None:
            raise RuntimeError("Keyboard not initialized. Call Keyboard.init().") 
        if isinstance(key, tuple):
            key_codes = key
            return any(c in cls._pressed for c in key_codes) 
        if isinstance(key, int):
            return key in cls._pressed 
        key = str(key).lower()
        return any(key == cls._names.get(c) for c in cls._pressed)

    @classmethod
    def get_pressed(cls, names=True):
        return [cls._names.get(c, str(c)) for c in cls._pressed] if names else list(cls._pressed)

    @classmethod
    def wait(cls, key):
        if cls._keyboard is None:
            raise RuntimeError("Keyboard not initialized. Call Keyboard.init().")
        cls._keyboard.wait(key)

# Exemple d'utilisation
# if __name__ == "__main__":
#     import time

#     Keyboard.init()
#     print("Appuyez sur 'esc' pour quitter...")

#     try:
#         while True:
#             time.sleep(0.1)
#             if Keyboard.is_pressed(Keyboard.KEY_RIGHT): 
#                 print("La touche 'droite' est pressée !")
#             if Keyboard.is_pressed(Keyboard.KEY_UP): 
#                 print("La touche 'haut' est pressée !")
#             if Keyboard.is_pressed("esc"):
#                 print("Fermeture...")
#                 break
#     except KeyboardInterrupt:
#         pass 