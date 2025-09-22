from datetime import datetime, date, time, timedelta, timezone

class Date(datetime): 
    # 🔹 Constructeurs
    @classmethod
    def now(cls, tz=None):
        return cls.from_datetime(datetime.now(tz))

    @classmethod
    def today(cls):
        return cls.from_datetime(datetime.today())

    @classmethod
    def from_datetime(cls, dt: datetime):
        return cls(dt.year, dt.month, dt.day, dt.hour, dt.minute, dt.second, dt.microsecond, dt.tzinfo)

    @classmethod
    def parse(cls, value): 
        if value is None:
            return cls.now()
        elif isinstance(value, (int, float)):  # timestamp
            return cls.from_datetime(datetime.fromtimestamp(value))
        elif isinstance(value, datetime):
            return cls.from_datetime(value)
        elif isinstance(value, date):
            return cls.from_datetime(datetime.combine(value, time()))
        elif isinstance(value, str):
            try:
                return cls.from_datetime(datetime.fromisoformat(value))
            except ValueError:
                return cls.from_datetime(datetime.fromtimestamp(float(value)))
        else:
            raise TypeError(f"Type de date non supporté : {type(value)}")

    # 🔹 Helpers add/sub
    def add(self, **kwargs):
        return self + timedelta(**kwargs)

    def subtract(self, **kwargs):
        return self - timedelta(**kwargs)

    def add_days(self, days): return self.add(days=days)
    def add_hours(self, hours): return self.add(hours=hours)
    def add_minutes(self, minutes): return self.add(minutes=minutes)
    def add_seconds(self, seconds): return self.add(seconds=seconds)
    def add_weeks(self, weeks): return self.add(weeks=weeks)

    # 🔹 Conversions
    def timestamp(self): return int(super().timestamp())
    def format(self, fmt="%Y-%m-%d %H:%M:%S"): return self.strftime(fmt)
    def to_date(self): return date(self.year, self.month, self.day)
    def to_time(self): return time(self.hour, self.minute, self.second, self.microsecond, self.tzinfo)
    def to_datetime(self): return datetime.fromtimestamp(self.timestamp(), tz=self.tzinfo)

    # 🔹 Comparisons
    def is_before(self, other): return self < Date.parse(other)
    def is_after(self, other): return self > Date.parse(other)
    def is_between(self, start, end): return Date.parse(start) <= self <= Date.parse(end)
    def is_same_day(self, other): return self.date() == Date.parse(other).date()

    # 🔹 Differences
    def diff(self, other, unit="seconds"):
        delta = self - Date.parse(other)
        seconds = delta.total_seconds()
        if unit == "seconds": return seconds
        if unit == "minutes": return seconds / 60
        if unit == "hours": return seconds / 3600
        if unit == "days": return delta.days
        if unit == "weeks": return delta.days / 7
        return seconds

    # 🔹 Boundaries
    def start_of_day(self): return self.replace(hour=0, minute=0, second=0, microsecond=0)
    def end_of_day(self): return self.replace(hour=23, minute=59, second=59, microsecond=999999)
    def start_of_month(self): return self.replace(day=1, hour=0, minute=0, second=0, microsecond=0)
    def end_of_month(self):
        next_month = self.add(months=1) if self.month < 12 else self.replace(year=self.year+1, month=1)
        return (next_month.start_of_month() - timedelta(microseconds=1))
    def start_of_year(self): return self.replace(month=1, day=1, hour=0, minute=0, second=0, microsecond=0)
    def end_of_year(self): return self.replace(month=12, day=31, hour=23, minute=59, second=59, microsecond=999999)

    # 🔹 Utility
    def copy(self): return self.from_datetime(self)
    def replace_safe(self, **kwargs): return self.from_datetime(super().replace(**kwargs))

    # 🔹 Représentation
    def __repr__(self): return f"Date({self.isoformat()})"
    def __str__(self): return self.format()
