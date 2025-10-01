import json

class Response:
    def __init__(self, content=None, status=200, headers=None):
        self.content = content
        self.status = status
        self.headers = headers or {}

    def alert(self, status, *messages):
        pass 