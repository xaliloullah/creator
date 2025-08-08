from src.core import Storage

class Devise(Storage):
    def __init__(self, value:int=None, rate:str=None):
        self.path = 'tools/devise'
        super().__init__(self.path, format="json", absolute=True, default={})  
        self.value = int(value)
        self.data = self.load() or {}
        self.base = Rate('XOF')
        self.rate = Rate(rate.upper() or self.base.code)
        self.rates = self.data.get('rates', {})
        self.api_url = f"https://open.er-api.com/v6/latest/{self.base.code}"
        self.supported = None

    def update(self):
        import requests 
        response = requests.get(self.api_url)
        if response.status_code == 200:
            self.data = response.json() 
            if 'rates' in self.data:
                self.rates = self.data['rates']
            return self.save()
        return False

    def convert(self, to:str=None):
        from_currency = self.rate.code
        to_currency = to.upper() or self.base.code

        if from_currency not in self.rates or to_currency not in self.rates:
            return self

        self.value = round((self.value / self.rates[from_currency]) * self.rates[to_currency], 2)
        self.set_current(to_currency)
        return self

    def base_currency(self):
        self.value *= (self.rates[self.base.code] / self.rates[self.get_current().code])
        self.set_current(self.base.code)
        return self

    def format_currency(self, decimals=0, separator=',', thousand=' ', devise=False):
        return f"{self.value:,.{decimals}f}".replace(",", "tmp").replace(".", separator).replace("tmp", thousand)

    def get_base(self):
        return self.base

    def set_base(self, rate):
        self.base = Rate(rate)

    def get_current(self):
        return self.rate

    def set_current(self, rate:str):
        self.rate = Rate(rate.upper()) 

    def is_valid(self, rate):
        return rate in self.rates  

    def __str__(self):
        return str(self.value)
    

class Rate:
    names = {
        'EUR': 'Euro',
        'USD': 'Dollar',
        'GBP': 'Livre Sterling',
        'JPY': 'Yen',
        'INR': 'Roupie Indienne',
        'XOF': 'Franc CFA',
        'CHF': 'Franc Suisse',
        'CRC': 'Colón Costaricain',
        'PYG': 'Guarani Paraguyen',
        'UAH': 'Hryvnia Ukrainienne',
        'RUB': 'Rouble Russe'
    }

    symbols = {
        'EUR': '€',
        'USD': '$',
        'GBP': '£',
        'JPY': '¥',
        'INR': '₹',
        'XOF': 'F',
        'CHF': '₣',
        'CRC': '₡',
        'PYG': '₲',
        'UAH': '₴',
        'RUB': '₽',
    }

    def __init__(self, code:str):
        self.code = code.upper()
        self.name = self.get_name()
        self.symbol = self.get_symbol()

    def get_symbol(self):
        return self.symbols.get(self.code, self.code)

    def get_name(self):
        return self.names.get(self.code, self.code)

    def get_code(self):
        return self.code

    def __str__(self):
        return self.code