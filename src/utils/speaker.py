from typing import Any


class Speaker: 
    langs = {
        "en": "English",
        "fr": "French",
        "es": "Spanish",
        "de": "German",
        "it": "Italian",
        "pt": "Portuguese",
        "zh": "Chinese",
        "ja": "Japanese",
        "ko": "Korean",
        "ru": "Russian"
    }

    @classmethod
    def setup(cls, **kwargs): 
        cls.lang: str = kwargs.get('lang', 'en')
        cls.rate: int = kwargs.get('rate', 180)
        cls.volume: float = kwargs.get('volume', 1.0)  
        try:
            import pyttsx3
            cls.engine = pyttsx3.init()
        except:
            raise ImportError("pyttsx3 module is not installed.")
        
        cls.engine.setProperty("rate", cls.rate)
        cls.engine.setProperty("volume", cls.volume)
        cls.voice = cls.set_voice(cls.lang)
        return cls

    @classmethod
    def set_voice(cls, lang: str): 
        voices:Any = cls.engine.getProperty("voices")
        for voice in voices:
            if cls.langs.get(lang, "").lower() in voice.name.lower():
                cls.engine.setProperty("voice", voice.id)
                return voice.name 
        cls.engine.setProperty("voice", voices[0].id)
        return voices[0].name

    @classmethod
    def say(cls, text: str):  
        cls.engine.say(text)
        cls.engine.runAndWait()