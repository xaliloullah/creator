import json

class Response:
    def __init__(self, data):
        self.data = data
    
    def text(self):
        return self.data
 
    def json(self):
        return json.dumps(self.data, indent=2)

    @staticmethod
    def error(message):
        print(f"[ERROR] {message}")
