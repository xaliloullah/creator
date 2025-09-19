from src.console import Terminal

terminal = Terminal

# while True:
terminal.table({
"Nom": "Alice",
"Âge": 25,
"Ville": "Paris",
"Email": "alice@example.com",
"Téléphone": "+33 6 12 34 56 78",
"Statut": "Actif"
}, keys=['Nom', 'Ville']
, display=True)
    # event = keyboard.read_event()  # lit un évènement clavier
    # if event.event_type == keyboard.KEY_DOWN:  # quand une touche est pressée
    #     print(event.scan_code)
    #     if event.name == "esc":  # condition pour quitter
    #         break
