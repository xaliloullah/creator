import sys
import os
 
sys.path.append(os.path.abspath(os.path.join(__file__, "..", "..")))

import sys
from PyQt5.QtWidgets import QApplication, QMainWindow
from src.core.interface import Interface  # Ta classe Interface

def main():
    app = QApplication(sys.argv)
    
    # 1. Créer la fenêtre principale
    window = QMainWindow()
    window.resize(800, 600)
    
    # 2. Configurer Interface avec la fenêtre
    Interface.setup(window)
    Interface.title("Exemple Use Case PyQt5")
    
    # 3. Ajouter une zone centrale
    body = Interface.body(style="background: #f0f0f0;")
    
    # 4. Ajouter un label
    label = Interface.label("Bonjour !", parent=body, position=(50, 50), width=200, height=50)
    
    # 5. Ajouter un input
    user_input = Interface.input(parent=body, position=(50, 120), width=300)
    
#     # 6. Ajouter un bouton
#     def on_click():
#         text = user_input.text()
#         label.setText(f"Salut, {text} !")
#         Interface.window.statusBar().showMessage(f"Texte mis à jour: {text}")
    
#     button = Interface.button("Valider", parent=body, position=(50, 180), width=100, action=on_click)
    
#     # 7. Ajouter une barre de menu simple
#     menu_bar = Interface.menu_bar(window)
    
#     # 8. Ajouter une status bar
#     window.statusBar().showMessage("Prêt")
    
#     # 9. Afficher la fenêtre
#     window.show()
#     sys.exit(app.exec_())

if __name__ == "__main__":
    main()
