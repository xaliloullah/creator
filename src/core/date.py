import datetime

class Date:
    def __init__(self, date=None):
        self._date = self._parse_date(date)

    @staticmethod
    def _parse_date(date):
        """Parse différents types d'entrée en datetime.datetime"""
        if date is None:
            return datetime.datetime.now()
        elif isinstance(date, (int, float)):  # timestamp
            return datetime.datetime.fromtimestamp(date)
        elif isinstance(date, datetime.datetime):
            return date
        elif isinstance(date, datetime.date):
            return datetime.datetime.combine(date, datetime.time())
        elif isinstance(date, str):
            try:
                return datetime.datetime.fromisoformat(date)
            except ValueError:
                try:
                    return datetime.datetime.fromtimestamp(float(date))
                except ValueError:
                    raise ValueError(f"Impossible d'interpréter la date : {date}")
        else:
            raise TypeError(f"Type de date non supporté : {type(date)}")

    # 🔹 Constructeurs alternatifs
    @classmethod
    def now(cls):
        return cls(datetime.datetime.now())
    
    @classmethod
    def today(cls):
        return cls(datetime.date.today())

    # 🔹 Opérations
    def add(self, **kwargs):
        """Ajouter un intervalle de temps (jours, heures, minutes, etc.)"""
        self._date += datetime.timedelta(**kwargs)
        return self

    def subtract(self, **kwargs):
        """Soustraire un intervalle de temps"""
        self._date -= datetime.timedelta(**kwargs)
        return self

    # 🔹 Raccourcis
    def add_days(self, days): return self.add(days=days)
    def add_hours(self, hours): return self.add(hours=hours)
    def add_minutes(self, minutes): return self.add(minutes=minutes)
    def add_seconds(self, seconds): return self.add(seconds=seconds)
    def add_weeks(self, weeks): return self.add(weeks=weeks)
    
    def subtract_days(self, days): return self.subtract(days=days)

    # 🔹 Outputs
    def datetime(self): return self._date
    def timestamp(self): return int(self._date.timestamp())
    def date(self): return self._date.date()
    def time(self): return self._date.time()
    def to_string(self, fmt="%Y-%m-%d %H:%M:%S"): return self._date.strftime(fmt)

    # 🔹 Comparaisons
    def __eq__(self, other): return isinstance(other, Date) and self._date == other._date
    def __lt__(self, other): return isinstance(other, Date) and self._date < other._date
    def __le__(self, other): return isinstance(other, Date) and self._date <= other._date
    def __gt__(self, other): return isinstance(other, Date) and self._date > other._date
    def __ge__(self, other): return isinstance(other, Date) and self._date >= other._date

    # 🔹 Représentation
    def __repr__(self): return f"Date({self._date.isoformat()})"
    def __str__(self): return self.to_string()
