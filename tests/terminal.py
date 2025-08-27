import sys
import os
 
sys.path.append(os.path.abspath(os.path.join(__file__, "..", "..")))

from src.console import Terminal

terminal = Terminal()
 
import keyboard

print("Tape sur ton clavier (appuie sur 'esc' pour quitter):")

while True:
    print(terminal.keyboard())
    # event = keyboard.read_event()  # lit un évènement clavier
    # if event.event_type == keyboard.KEY_DOWN:  # quand une touche est pressée
    #     print(event.scan_code)
    #     if event.name == "esc":  # condition pour quitter
    #         break
