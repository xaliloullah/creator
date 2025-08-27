import cv2

# 0 = première caméra détectée (webcam par défaut)
cap = cv2.VideoCapture(0)

if not cap.isOpened():
    print("❌ Impossible d'accéder à la caméra")
    exit()

while True:
    # Lire une image de la caméra
    ret, frame = cap.read()
    if not ret:
        print("Erreur lors de la capture")
        break

    # Afficher l'image dans une fenêtre
    cv2.imshow("Camera", frame)

    # Appuyer sur 'q' pour quitter
    if cv2.waitKey(1) & 0xFF == ord('q'):
        break

# Libérer la caméra et fermer la fenêtre
cap.release()
cv2.destroyAllWindows()
