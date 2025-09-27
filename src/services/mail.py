import smtplib
import ssl
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart
from email.mime.base import MIMEBase
from email import encoders
import os
from typing import Any
from config import mail
from src.core import Data 


class Email:
    def __init__(self):
        mailer = self.config(mail.engine)
        self.host = mailer["host"]
        self.port = mailer["port"] 
        self.username = mailer["username"]
        self.password = mailer["password"]
        self.encryption = mailer.get("encryption", "tls").lower() # Encryption type: "tls" | "ssl" | "none"

    def config(self, engine: Any | str) -> dict:  
        mailers = mail.mailers
        if engine not in mailers:
            raise Exception(f"No configuration found for engine: {engine}")
        mailer = mailers[engine]
        mailer["from"] = mail.mailers['from']  # address, name
        return mailer

    def send(self, to, subject, body:Any|str=None, cc=None, bcc=None, attachments=None): 
        if isinstance(to, str):
            to = to.split(",")
        if isinstance(cc, str):
            cc = [cc]
        if isinstance(bcc, str):
            bcc = [bcc]

        # Construction du message
        msg = MIMEMultipart("mixed")
        msg["From"] = self.username
        msg["To"] = ", ".join(to)
        msg["Subject"] = subject
        if cc:
            msg["Cc"] = ", ".join(cc)

        # Partie texte/HTML
        alternative_part = MIMEMultipart("alternative")
        if Data(body).is_html():
            alternative_part.attach(MIMEText(body, "html"))
        else:
            alternative_part.attach(MIMEText(body, "plain")) 
        msg.attach(alternative_part)

        # Ajout des pièces jointes
        if attachments:
            for file_path in attachments:
                if os.path.isfile(file_path):
                    with open(file_path, "rb") as f:
                        part = MIMEBase("application", "octet-stream")
                        part.set_payload(f.read())
                        encoders.encode_base64(part)
                        part.add_header(
                            "Content-Disposition",
                            f'attachment; filename="{os.path.basename(file_path)}"',
                        )
                        msg.attach(part)
                else:
                    raise FileNotFoundError(f"Attachment not found: {file_path}") 
        recipients = to + (cc or []) + (bcc or [])
        try:
            context = ssl.create_default_context()

            if self.encryption == "ssl":
                with smtplib.SMTP_SSL(self.host, self.port, context=context) as server:
                    server.login(self.username, self.password)
                    server.sendmail(self.username, recipients, msg.as_string())

            else:
                if self.encryption == "tls":
                    with smtplib.SMTP(self.host, self.port) as server:
                        server.starttls(context=context)
                        server.login(self.username, self.password)
                        server.sendmail(self.username, recipients, msg.as_string()) 

            return True, "Email sent successfully"
        except Exception as e:
            return False, str(e)

