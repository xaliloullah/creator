import unittest

class Test(unittest.TestCase):
    """
    Classe de base pour tous les tests de l'application.
    Fournit setup et teardown automatiques, et peut être étendue.
    """

    @classmethod
    def setUpClass(cls):
        """Exécuté une seule fois avant tous les tests de la classe"""
        print(f"\n>>> Démarrage des tests pour {cls.__name__}")

    @classmethod
    def tearDownClass(cls):
        """Exécuté une seule fois après tous les tests de la classe"""
        print(f">>> Fin des tests pour {cls.__name__}")

    def setUp(self):
        """Exécuté avant chaque test"""
        print(f"--- Préparation du test {self._testMethodName}")

    def tearDown(self):
        """Exécuté après chaque test"""
        print(f"--- Fin du test {self._testMethodName}")

    # Méthodes d'assertions supplémentaires si nécessaire
    def assertNotEmpty(self, value, msg=None):
        """Vérifie que la valeur n'est pas vide"""
        if not value:
            self.fail(msg or f"Valeur vide détectée : {value}")
