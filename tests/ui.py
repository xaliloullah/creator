# Auto-generated test for ui
from src.interfaces import Interface
def test_ui():

    # Test 'ui' functionality.
    
    # TODO: Add assertions here

    ui = Interface(title="Exemple Complet", width=1200, height=700)

    # ---------- Widgets de base ----------
    ui.label("Ceci est un label", position=(20, 20), size=(200, 30))
    ui.button("Cliquez ici", action=lambda: ui.message("Bouton cliqué!"), position=(250, 20), size=(150, 30))
    ui.input("Tapez quelque chose", position=(20, 70), size=(200, 30))
    ui.textarea("Zone de texte...", position=(20, 120), size=(300, 100))

    # ---------- Sélections ----------
    ui.checkbox("Case à cocher", position=(350, 20), size=(150, 30))
    ui.radio("Bouton radio", position=(350, 60), size=(150, 30))
    ui.select(["Option 1", "Option 2", "Option 3"], position=(350, 100), size=(150, 30))

    # ---------- Sliders et Spinboxes ----------
    ui.slider(position=(520, 20), size=(200, 30))
    ui.spinbox(position=(520, 70), size=(100, 30))
    ui.doublespinbox(position=(520, 120), size=(100, 30))

    # ---------- Progress Bar ----------
    ui.progress(value=50, min=0, max=100, position=(520, 170), size=(200, 30))

    # ---------- Image ----------
    # Remplace 'path/to/image.png' par un chemin valide sur ton ordinateur
    # ui.image("path/to/image.png", position=(750, 20), size=(200, 150))

    # ---------- Table ----------
    data = [
        {"Nom": "Alice", "Age": 25},
        {"Nom": "Bob", "Age": 30},
        {"Nom": "Charlie", "Age": 22},
    ]
    ui.table(data, position=(20, 250), size=(350, 150))

    # ---------- Liste ----------
    ui.list(["Item 1", "Item 2", "Item 3"], position=(400, 250), size=(150, 100))

    # ---------- Tree ----------
    tree_data = {
        "Parent 1": {"Enfant A": 1, "Enfant B": 2},
        "Parent 2": {"Enfant C": 3}
    }
    ui.tree(tree_data, position=(600, 250), size=(250, 150))

    # ---------- Scrollbar ----------
    ui.scrollbar(position=(880, 250), size=(20, 150))

    # ---------- Dialogues ----------
    ui.button("Ouvrir fichier", action=lambda: print("Fichier:", ui.file_dialog()), position=(20, 420), size=(150, 30))
    ui.button("Choisir couleur", action=lambda: print("Couleur:", ui.color_dialog().name()), position=(200, 420), size=(150, 30))
    ui.button("Message", action=lambda: ui.message("Ceci est un message!"), position=(380, 420), size=(150, 30))

    # ---------- Toolbar ----------
    toolbar = ui.toolbar("Ma Toolbar")
    action1 = ui.action("Action 1", trigger=lambda: ui.status("Action 1 cliquée"))
    action2 = ui.action("Action 2", trigger=lambda: ui.status("Action 2 cliquée"))
    toolbar.addAction(action1)
    toolbar.addAction(action2)


    # Onglets
    tabs = {
        "Page 1": ui.label("Contenu page 1"),
        "Page 2": ui.label("Contenu page 2")
    }
    ui.tab(tabs, position=(20, 20), size=(400, 200))

    # Scrollable
    textarea = ui.textarea("Texte très long à scroller...")
    ui.scroll_area(textarea, position=(450, 20), size=(300, 200))

    # GraphicsView zoomable
    ui.graphics_view(pixmap_path="C:/creator/Projets/Python/creator/resources/assets/images/logo.png", position=(20, 250), size=(400, 300))

    # Splitter
    label1 = ui.label("Widget 1")
    label2 = ui.label("Widget 2")
    ui.splitter([label1, label2], position=(450, 250), size=(300, 300))


    # ---------- Status Bar ----------
    ui.status("Prêt à utiliser l'interface")

    # Lancement de l'interface
    # ui.start()
