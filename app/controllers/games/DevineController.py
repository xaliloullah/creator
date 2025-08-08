from app.models.games.devine import Devine
from main import Creator


class DevineController:
    from src.application.contexts import Request


    @classmethod
    def start():
        while True:
            guess = self.view.demander_nombre()
            Devine.essais.append(guess)
            if guess == self.model.secret:
                self.view.afficher_message("Bravo, trouvé !")
                break
            elif guess < self.model.secret:
                self.view.afficher_message("Trop petit !")
            else:
                self.view.afficher_message("Trop grand !")
        return Creator.view("layouts.games.devine.index")