import socket
import threading
from config import app

class Client:
    def __init__(self, host=app.host, port=app.port):
        self.host = host
        self.port = port
        self._server_ = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

    def start(self):
        self._server_.connect((self.host, self.port))
        print("✅ Connecté au serveur de chat")

        # Thread pour écouter les messages entrants
        receive_thread = threading.Thread(target=self.response)
        receive_thread.start()

        # Boucle pour envoyer des messages
        while True:
            msg = input("✏️ Vous : ")
            self._server_.sendall(msg.encode("utf-8"))

    def response(self): 
        while True:
            try:
                msg = self._server_.recv(1024).decode("utf-8")
                if msg:
                    print("\n📩 Nouveau message :", msg)
            except:
                print("❌ Déconnecté du serveur")
                self._server_.close()
                break


if __name__ == "__main__":
    client = Client()
    client.start()
