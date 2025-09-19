import random
import time

# Paramètres du jeu
secret = random.randint(1, 100)  # Le nombre secret est aléatoire
essais = 10
coeur = "💖"

print("🎯 BIENVENUE DANS LE JEU DE DEVINETTE MAGIQUE 🎯")
print("Un nombre secret entre 1 et 100 a été choisi...")
print("À vous de le découvrir en moins de 10 essais !")
print()

# Boucle principale
for i in range(essais):
    print(f"Essai {i+1}/{essais} {coeur*(essais-i)}")
    try:
        reponse = int(input("🔢 Devinez le nombre : "))
    except ValueError:
        print("⚠️ Veuillez entrer un nombre valide.")
        continue

    if reponse == secret:
        print(f"\n✨ BRAVO 🎉 Vous avez trouvé le nombre secret ({secret}) en {i+1} essais !")
        print("🏆 Vous êtes un vrai devin !")
        break
    elif reponse > secret:
        print("🔽 Trop grand ! Essayez un nombre plus petit.")
    elif reponse < secret:
        print("🔼 Trop petit ! Essayez un nombre plus grand.")
    print("")

else:
    # Si la boucle se termine sans avoir break (donc sans avoir gagné)
    print("\n💀 GAME OVER 💀")
    print(f"Le nombre secret était : {secret}")
    print("Ne vous découragez pas, retentez votre chance !")

print("\n🎮 Merci d'avoir joué 🎮")
