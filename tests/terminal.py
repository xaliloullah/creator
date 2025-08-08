import sys
import os
 
sys.path.append(os.path.abspath(os.path.join(__file__, "..", "..")))

from src.console import Terminal

terminal = Terminal()
# text = terminal.style(terminal.color.green, terminal.format.italic, "test 1", "test 3", terminal.color.grey, "salut", terminal.color.yellow)
# # terminal.animate("blocks")
# terminal.echo(text)
terminal.box(["Test", "test"], color=Terminal.color.cyan, width=400)