# # --- FTP ---
# ftp_client = FTPClient("ftp.example.com", "user", "pass")
# ftp_client.upload("local.txt", "remote.txt")
# ftp_client.download("remote.txt", "copie_local.txt")
import ftplib
class FTPClient:
    def __init__(self, host, username, password):
        self.host = host
        self.username = username
        self.password = password

    def upload(self, local_file, remote_file):
        """
        Upload un fichier vers le serveur FTP.
        """
        try:
            with ftplib.FTP(self.host) as ftp:
                ftp.login(self.username, self.password)
                with open(local_file, "rb") as f:
                    ftp.storbinary(f"STOR {remote_file}", f)
            print("✅ Fichier uploadé via FTP")
        except Exception as e:
            print("❌ Erreur FTP :", e)

    def download(self, remote_file, local_file):
        """
        Télécharge un fichier depuis le serveur FTP.
        """
        try:
            with ftplib.FTP(self.host) as ftp:
                ftp.login(self.username, self.password)
                with open(local_file, "wb") as f:
                    ftp.retrbinary(f"RETR {remote_file}", f.write)
            print("✅ Fichier téléchargé via FTP")
        except Exception as e:
            print("❌ Erreur FTP :", e)
