# src/core/http.py
import json

class Response:
    def __init__(self, content):
        self.content = content 

    def alert(self, status, *messages):
        pass