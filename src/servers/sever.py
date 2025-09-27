import socket
import threading
from config import app

class Server:

    def __init__(self, host=app.host, port=app.port):
        self.host = host
        self.port = int(port)
        self.server = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        self.server.settimeout(1.0)
        self.clients = []
        self.running = True
        self.queue = 10

    def start(self):
        self.server.bind((self.host, self.port))
        self.server.listen(self.queue) 
        try:
            while self.running:
                try:
                    client, address = self.server.accept()
                except socket.timeout:
                    continue
                print(f"🔗 Nouveau client : {address} {client}")
                self.clients.append(client)
                thread = threading.Thread(target=self.handle, args=(client,))
                thread.daemon = True
                thread.start()
        except KeyboardInterrupt: 
            self.stop()

    def broadcast(self, message, sender):
        for client in self.clients:
            if client != sender:
                try:
                    client.sendall(message.encode("utf-8"))
                except:
                    self.clients.remove(client)

    def handle(self, client):
        while True:
            try:
                data = client.recv(1024).decode("utf-8")
                if not data:
                    break
                print(f"📥 : {data}")
                self.broadcast(data, client)
            except:
                break

        client.close()
        if client in self.clients:
            self.clients.remove(client)
        print("❌ Client déconnecté")

    def stop(self):
        self.running = False 
        for client in self.clients:
            try:
                client.close()
            except:
                pass
        self.server.close() 