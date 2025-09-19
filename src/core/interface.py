import sys
try:
    from PyQt5.QtWidgets import (
        QApplication, QMainWindow, QWidget, QFrame, QLabel,
        QPushButton, QLineEdit, QCheckBox, QRadioButton, QSlider, QDialog, QProgressBar, QComboBox, QTableWidget, QTableWidgetItem, QTreeWidget
    )
    from PyQt5.QtCore import Qt
    from PyQt5.QtGui import QIcon, QPixmap, QCursor
except ImportError as e:
    raise ImportError("PyQt5 must be installed in your venv. Run: creator install PyQt5") from e

class Interface(QMainWindow):

    def __init__(self, **kwargs):
        self.app = QApplication(sys.argv)
        self.widgets = []
        super().__init__()

        title = kwargs.get('title', 'Creator')
        self._width = kwargs.get('width', 1500)
        self._height = kwargs.get('height', self._width // 2)
        style = kwargs.get('style', None)
        icon = kwargs.get('icon', None)

        self.setWindowTitle(title)
        self.resize(self._width, self._height)

        self.body = QWidget()
        self.body.setProperty("class", style) 
        self.setCentralWidget(self.body) 
        self.setWindowIcon(QIcon(icon))

    def styles(self, src) -> None:
        from src.core import File 
        self.setStyleSheet(File(src).load())
 
    def responsive(self, width, height):
        scale_width = self.width() / self._width
        scale_height = self.height() / self._height
        return int(width * scale_width), int(height * scale_height)

    def resizeEvent(self, event): 
        for item in self.widgets: 
            widget:QWidget = item["widget"]
            x, y = item["position"]
            width, height = item["size"] 
            if width:  
                widget.resize(*self.responsive(width, height))
            widget.move(*self.responsive(x, y)) 
        super().resizeEvent(event)

    def add(self, widget: QWidget, **kwargs):
        parent: QWidget = kwargs.get("parent", self.body)
        position = kwargs.get("position", (0, 0))
        size = kwargs.get("size", (parent.width(), parent.height()))
        style = kwargs.get("style", None)

        widget.setParent(parent)
        widget.move(*position)
        widget.resize(*size)
        widget.setProperty("class", style)
        
        min_width = kwargs.get("min_width", False)
        min_heigth = kwargs.get("min_heigth", False)
        max_width = kwargs.get("max_width", False)
        max_heigth = kwargs.get("max_heigth", False)
        
        if min_width:
            widget.setMinimumWidth(min_width)
        if min_heigth:
            widget.setMinimumHeight(min_heigth)
        if max_width:
            widget.setMaximumWidth(max_width)
        if max_heigth:
            widget.setMaximumHeight(max_heigth)

        self.widgets.append({
            "widget": widget,
            "position": position,
            "size": size,
        })
        return widget

    def modal(self, title="Modal", **kwargs):
        modal = QDialog()
        modal.setWindowTitle(title)
        modal.setModal(True)  
        style = kwargs.get("style", None)
        modal.setProperty("class", style)
        modal.setFixedSize(*kwargs.get("size", [900, 500]))
        return modal
    
    def select(self, options=None, **kwargs): 
        combo = QComboBox(self.body)
        combo.move(*kwargs.get("position", [10, 10]))
        combo.resize(*kwargs.get("size", [150, 40]))
        combo.show()
        combo.addItems(options)
        return combo
    
    def label(self, title, **kwargs):
        return self.add(QLabel(title), **kwargs)

    def card(self, **kwargs):
        return self.add(QFrame(), **kwargs)
    
    def button(self, title, action=None,**kwargs):
        button = QPushButton(title) 
        button.setCursor(QCursor(Qt.PointingHandCursor)) 
        if action:
            button.clicked.connect(action)
        return self.add(button, **kwargs)

    def input(self, placeholder="", **kwargs):
        widget = QLineEdit()
        widget.setPlaceholderText(placeholder)
        return self.add(widget, **kwargs)

    def radio(self, title, **kwargs):
        return self.add(QRadioButton(title), **kwargs)
    
    def radio(self, title, **kwargs):
        return self.add(QTreeWidget(title), **kwargs)
    
    def checkbox(self, title, **kwargs):
        return self.add(QCheckBox(title), **kwargs)

    def slider(self, orientation=Qt.Horizontal, **kwargs):
        widget = QSlider(orientation)
        return self.add(widget, **kwargs)
    
    def progress(self, **kwargs):
        widget = QProgressBar(kwargs.get("parent", self.body))
        min_val = kwargs.get("min", 0)
        max_val = kwargs.get("max", 100)
        value = kwargs.get("value", 0)

        widget.setMinimum(min_val)
        widget.setMaximum(max_val)
        widget.setValue(value)
        return self.add(widget, **kwargs)

    def image(self, path, **kwargs):
        image = QLabel()
        pixmap = QPixmap(path)
        image.setPixmap(pixmap)
        image.setScaledContents(True) 
        return self.add(image, **kwargs)
    
    def table(self, data: list, **kwargs):
        if not data:
            return None
        headers = list(data[0].keys())
        table = QTableWidget(len(data), len(headers))
        table.setHorizontalHeaderLabels(headers)
        for row_idx, row_data in enumerate(data):
            for col_idx, key in enumerate(headers):
                table.setItem(row_idx, col_idx, QTableWidgetItem(str(row_data[key])))
        return self.add(table, **kwargs)


    def start(self):
        self.show()
        sys.exit(self.app.exec_())

# from src.core import Path
if __name__ == "__main__":
    interface = Interface(title="Creator", icon="resources/assets/images/logo.png")

    # Label sur le body
    interface.label("Bienvenue dans QMainWindow", position=(50, 20), size=(300, 50))

    # Card avec taille visible
    card = interface.card(position=(50, 100), size=(500, 500))

    # Label à l'intérieur de la card
    interface.label("Deuxième label ajouté dynamiquement", parent=card, position=(10, 10))
    interface.image("resources/assets/images/logo.png", parent=card, position=(100, 10), size=(100, 100))

    # Bouton dans la card
    modal = interface.modal("Test Modal...",  size=(800, 500))
    interface.button("Fermer", parent=modal, action=modal.accept, position=(10, 50), size=(120, 50))
    interface.button("Ouvrir", parent=card, action=modal.show, position=(10, 50), size=(120, 40))

    # Input dans la card
    interface.input("Entrez votre texte...", parent=card, position=(10, 100), size=(300, 50))
    interface.select(options=["Option 1", "Option 2", "Option 3"], 
        position=(300, 400),
        size=(150, 40)
    ) 
    # Checkbox dans la card 
    interface.progress(parent=card, position=(200, 30), size=(300, 15), value=40)
    interface.checkbox("Option 1", parent=card, position=(10, 140))

    # Slider horizontal sur le body
    interface.slider(position=(500, 50), size=(200, 30))

    data = [
        {"Nom": "Alice", "Âge": 25, "Ville": "Paris"},
        {"Nom": "Bob", "Âge": 30, "Ville": "Lyon"},
        {"Nom": "Charlie", "Âge": 22, "Ville": "Marseille"}
    ]

    interface.table(data, position=(100, 550), size=(1300, 150))


    interface.start()
