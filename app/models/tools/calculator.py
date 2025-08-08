import math
from src.core import Storage


class Calculator(Storage): 
    def __init__(self):
        self.path = 'tools/calculator'
        super().__init__(self.path, format="json", absolute=True, default={})
         
        self.data = self.load() or {} 
        self.variables = self.data.get("variables", {})
        self.ans = self.data.get("ans", 0) 
        self._history = self.data.get("history", [])

        self.allowed = {
            # Fonctions de base
            'abs': abs,
            'round': round,

            # Math standard
            'sqrt': math.sqrt,
            'log': math.log,
            'log10': math.log10,
            'exp': math.exp,
            'pow': pow,
            'floor': math.floor,
            'ceil': math.ceil,
            'factorial': math.factorial,

            # Trigonométrie (en degrés)
            'sin': lambda x: math.sin(math.radians(x)),
            'cos': lambda x: math.cos(math.radians(x)),
            'tan': lambda x: math.tan(math.radians(x)),
            'asin': lambda x: math.degrees(math.asin(x)),
            'acos': lambda x: math.degrees(math.acos(x)),
            'atan': lambda x: math.degrees(math.atan(x)),

            # Constantes
            'pi': math.pi,
            'e': math.e,
            'tau': math.tau,
        }

    def help(self):
        return {
            # Fonctions mathématiques
            'abs': 'abs(x) - valeur absolue',
            'round': 'round(x[, n]) - arrondit x à n décimales',
            'sqrt': 'sqrt(x) - racine carrée',
            'log': 'log(x[, base]) - logarithme (base e ou base donnée)',
            'log10': 'log10(x) - logarithme décimal',
            'exp': 'exp(x) - exponentielle de x',
            'pow': 'pow(x, y) - x puissance y',
            'factorial': 'factorial(x) - factorielle de x',
            'floor': 'floor(x) - arrondi inférieur',
            'ceil': 'ceil(x) - arrondi supérieur',

            # Trigonométrie (en degrés)
            'sin': 'sin(x) - sinus (x en degrés)',
            'cos': 'cos(x) - cosinus (x en degrés)',
            'tan': 'tan(x) - tangente (x en degrés)',
            'asin': 'asin(x) - arc sinus (résultat en degrés)',
            'acos': 'acos(x) - arc cosinus (résultat en degrés)',
            'atan': 'atan(x) - arc tangente (résultat en degrés)',

            # Constantes
            'pi': 'pi - constante π (3.1415...)',
            'e': 'e - constante e (2.718...)',
            'tau': 'tau - constante τ (2π)',

            # Variables et résultats
            'ans': 'ans - dernier résultat',
            'x = ...': 'Définit une variable : ex. x = 2 + 3',

            # Commandes spéciales
            'help': 'Affiche cette aide',
            'clear': 'Réinitialise les variables, le dernier résultat et l’historique',
            'history': 'Affiche l’historique des calculs',
            'exit': 'Quitte le programme (si applicable)',
        }

    def calculate(self, expression: str):
        try:
            expression = expression.strip()
            context = {**self.allowed, **self.variables, 'ans': self.ans}
            # Affectation de variable : ex "x = 2 + 3"
            if '=' in expression:
                var, expr = map(str.strip, expression.split('=', 1))
                if not var.isidentifier():
                    return f"Invalid variable name: {var}"
                result = eval(expr, {"__builtins__": {}}, context)
                self.variables[var] = result
                self.ans = result
                self._history.append(f"{var} = {result}") 
                self._save()
                return f"{var} = {result}"
            # Calcul normal
            result = eval(expression, {"__builtins__": {}}, context)
            self.ans = result
            if result:
                self._history.append(f"{expression} = {result}")
            self._save()
            return result
        except ZeroDivisionError:
            return "Erreur : Division par zéro"
        except Exception as e:
            return f"Erreur : Expression invalide ({e})"

    def _save(self):
        self.save({
            "variables": self.variables,
            "ans": self.ans,
            "history": self._history
        })

    def history(self):
        return self._history

    def clear(self):
        self.variables = {}
        self.ans = 0
        self._history = []
        self._save()