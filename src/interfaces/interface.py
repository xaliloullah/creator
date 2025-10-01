import sys
from typing import Any, Callable
try:
    from PyQt6.QtWidgets import (
        QApplication, QMainWindow, QWidget, QFrame, QLabel,
        QPushButton, QLineEdit, QCheckBox, QRadioButton, QSlider,
        QDialog, QProgressBar, QComboBox, QTableWidget, QTableWidgetItem,
        QTreeWidget, QTreeWidgetItem, QTextEdit, QListWidget, QListWidgetItem,
        QSpinBox, QDoubleSpinBox, QScrollBar, QFileDialog, QColorDialog,
        QMessageBox, QToolBar, QStatusBar, QGraphicsView, QGraphicsScene, QGraphicsPixmapItem, QTabWidget, QScrollArea, QSplitter, QStackedWidget
    )

    from PyQt6.QtCore import Qt, QPointF
    from PyQt6.QtGui import QIcon, QPixmap, QAction, QIntValidator, QDoubleValidator, QFontDatabase, QFont, QPainter, QPen, QColor, QMouseEvent
except ImportError:
    pass

class Interface:
    running = False

    @classmethod
    def setup(cls, title='Creator', width=900, height=None, icon=None, style=None, **kwargs): 
        if cls.running:
            return cls
        cls.app = QApplication(sys.argv)
        cls.window = QMainWindow()
        cls.widgets = [] 
        cls._sections = {}
        cls.width = width
        cls.height = height if height else width // 2 
        cls.window.resizeEvent = cls._resize_event  # type: ignore 
        cls.window.setWindowTitle(title)
        cls.window.resize(cls.width, cls.height)
        if icon: cls.window.setWindowIcon(QIcon(icon))
        cls.window.setStatusBar(QStatusBar()) 

        cls.body = QStackedWidget(cls.window)
        cls.body.resize(cls.width, cls.height)
        cls.body.setProperty("class", style)
        cls.window.setCentralWidget(cls.body)

        fixed = kwargs.get("fixed", False)
        min_width = kwargs.get("min_width", cls.width if fixed else None) 
        min_height = kwargs.get("min_height", cls.height if fixed else None)
        max_width = kwargs.get("max_width", cls.width if fixed else None)
        max_height = kwargs.get("max_height", cls.height if fixed else None)

        if min_width: cls.window.setMinimumWidth(min_width)
        if min_height: cls.window.setMinimumHeight(min_height)
        if max_width: cls.window.setMaximumWidth(max_width)
        if max_height: cls.window.setMaximumHeight(max_height) 
        return cls
    
    @classmethod
    def title(cls, title:str):
        cls.window.setWindowTitle(title)

    @classmethod
    def font(cls, src:str, size:int=16): 
        font_id = QFontDatabase.addApplicationFont(src)
        family = QFontDatabase.applicationFontFamilies(font_id)[0] 
        font = QFont(family, size)
        cls.window.setFont(font)


    @classmethod
    def styles(cls, src:str):
        from src.core import File
        cls.window.setStyleSheet(File(src).load())
        return cls  
    
    @classmethod
    def clear(cls):
        for item in cls.widgets:
            widget: QWidget = item["widget"]
            widget.setParent(None)
        cls.widgets = []
        cls._sections = {}
        cls.body = QStackedWidget(cls.window)
        cls.body.resize(cls.width, cls.height)
        cls.window.setCentralWidget(cls.body)


    @classmethod
    def format_size(cls, size, parent: QWidget)-> tuple: 
        pw, ph = parent.width(), parent.height() 
        if isinstance(size, (int, float, str)):
            size = (size, size)
        elif isinstance(size, (list, tuple)):
            size = tuple(size[:2])
        else:
            raise ValueError("size must be an int, str, or a tuple/list of two elements")
        w, h = size
        if isinstance(w, str) and w.endswith("%"): 
            w = pw * int(w.strip("%")) // 100
        if isinstance(h, str) and h.endswith("%"):
            h = ph * int(h.strip("%")) // 100

        return w, h

    @classmethod
    def format_position(cls, position, size, parent: QWidget):
        import re
        pw, ph = parent.width(), parent.height()
        w, h = size

        # si position est un seul nombre, on fait tuple (x, y)
        if isinstance(position, (int, float)):
            position = (position, position)
        elif isinstance(position, str):
            # on garde la string telle quelle pour parsing
            pass
        elif isinstance(position, (list, tuple)):
            position = tuple(position[:2])
        else:
            raise ValueError("position must be int, str, list or tuple")

        # fonction simple pour parser une valeur
        def parse(val, parent_size, own_size, is_horizontal=True):
            if isinstance(val, (int, float)):
                return int(val)
            x, y = 0, 0
            tokens = re.findall(r"(left|right|top|bottom|center|x-auto|y-auto|[-+]?\d+)", val.lower())
            pos = 0
            for token in tokens:
                if token in {"left"} and is_horizontal:
                    pos = 0
                elif token in {"right"} and is_horizontal:
                    pos = parent_size - own_size
                elif token in {"center", "x-auto"} and is_horizontal:
                    pos = (parent_size - own_size) // 2
                elif token in {"top"} and not is_horizontal:
                    pos = 0
                elif token in {"bottom"} and not is_horizontal:
                    pos = parent_size - own_size
                elif token in {"center", "y-auto"} and not is_horizontal:
                    pos = (parent_size - own_size) // 2
                else:
                    try:
                        pos += int(token)
                    except ValueError:
                        pass
            return pos

        if isinstance(position, str):
            # on sépare horizontal et vertical si possible
            parts = position.split()
            if len(parts) == 1:
                x = parse(parts[0], pw, w, True)
                y = parse(parts[0], ph, h, False)
            else:
                x = parse(parts[0], pw, w, True)
                y = parse(parts[1], ph, h, False)
        else:
            x = parse(position[0], pw, w, True)
            y = parse(position[1], ph, h, False)

        return x, y
    @classmethod
    def responsive(cls, width, height):
        scalewidth = cls.window.width() / cls.width
        scaleheight = cls.window.height() / cls.height
        return int(width * scalewidth), int(height * scaleheight)

    @classmethod
    def update(cls):
        cls.widgets.sort(key=lambda w: w.get("index", 0))
        # ratio de redimensionnement de la fenêtre
        scale_w = cls.window.width() / cls.width
        scale_h = cls.window.height() / cls.height

        for item in cls.widgets:
            widget: QWidget = item["widget"]
            parent = item.get("parent", cls.body)
            original_size = item["original_size"]
            original_position = item["original_position"]

            # ----------------
            # 1. Taille responsive
            # ----------------
            w, h = cls.format_size(original_size, parent)
            w = int(w * scale_w)
            h = int(h * scale_h)
            widget.resize(w, h)

            # ----------------
            # 2. Position responsive
            # ----------------
            # normaliser original_position en tuple (x, y)
            if isinstance(original_position, (int, float, str)):
                pos = (original_position, original_position)
            elif isinstance(original_position, (list, tuple)):
                pos = tuple(original_position[:2])
            else:
                raise ValueError("original_position must be int, float, str, or tuple/list")

            x, y = pos 
 
            x = int(x * scale_w) if isinstance(x, (int, float)) else x
            y = int(y * scale_h) if isinstance(y, (int, float)) else y 
            x, y = cls.format_position((x, y), (w, h), parent)
            widget.move(x, y)

            widget.raise_()


    
    @classmethod
    def _resize_event(cls, event):
        cls.update()
        event.accept() 
    
    @classmethod
    def widget(cls, widget: 'QWidget', **kwargs):
        parent:QWidget = kwargs.get("parent", cls.body)
        width       = kwargs.get("width", parent.width()) 
        height      = kwargs.get("height", parent.height())
        original_size        = kwargs.get("size", (width, height))
        size        = cls.format_size(original_size, parent)
        x           = kwargs.get("x", 0)
        y           = kwargs.get("y", 0)
        original_position    = kwargs.get("position", (x, y))
        position    = cls.format_position(original_position, size, parent)
        min_width   = kwargs.get("min_width", None)
        max_width   = kwargs.get("max_width", None)
        min_height  = kwargs.get("min_height", None)
        max_height  = kwargs.get("max_height", None)
        style       = kwargs.get("style", None) 
        tooltip     = kwargs.get("tooltip", None)
        font        = kwargs.get("font", None)
        cursor      = kwargs.get("cursor", None)
        hidden      = kwargs.get("hidden", False)
        disabled    = kwargs.get("disabled", False)
        fixed       = kwargs.get("fixed", False) 
        scrollable  = kwargs.get("scrollable", False)
        index = kwargs.get("index", 0)

        if scrollable: 
            widget = cls.scroll(widget)  

        widget.setParent(parent) 

        w, h = size
        
        if fixed: widget.setFixedSize(w, h) 
        else: widget.resize(w, h)
        # Contraintes
        if min_width: widget.setMinimumWidth(min_width)
        if max_width: widget.setMaximumWidth(max_width)
        if min_height: widget.setMinimumHeight(min_height)
        if max_height: widget.setMaximumHeight(max_height)

        # position
        widget.move(*position)

        if style:  widget.setProperty("class", style) 
        if tooltip: widget.setToolTip(tooltip) 
        if font: widget.setFont(font) 
        if cursor: widget.setCursor(cursor) 
        if hidden: widget.setVisible(False)
        if disabled: widget.setEnabled(False)  

        cls.widgets.append({
            "widget": widget, 
            "original_size": original_size,
            "original_position": original_position,  
            "parent": parent,
            "index": index,
        })

        if index > 0: widget.raise_()

        cls.update()
        return widget
    
    # ---------- Widgets ----------
    
    @classmethod
    def page(cls, name: str, widget: QWidget=None): 
        if not widget:
            if name in cls._sections:
                container = cls._sections[name]
                cls.body.setCurrentWidget(container)
            return
        if name not in cls._sections: 
            container = QWidget() 
            widget.setParent(container)  
            cls.body.addWidget(container)
            cls._sections[name] = container
        else:
            container = cls._sections[name]
        cls.body.setCurrentWidget(container)
        return widget
    
    @classmethod
    def modal(cls, title="Modal", **kwargs):
        parent:QWidget = kwargs.get("parent", cls.body)
        modal = QDialog(parent)
        modal.setWindowTitle(title)
        modal.setModal(True) 
        w = kwargs.get("width", parent.width() // 2)
        h = kwargs.get("height", parent.height() // 2)
        style = kwargs.get("style", None)
        if style: modal.setProperty("class", style)
        fixed = kwargs.get("fixed", False)
        if fixed:
            modal.setFixedSize(w, h)
        else:
            modal.resize(w, h) 
        return modal

    @classmethod
    def select(cls, options=None, **kwargs):
        combo = QComboBox(cls.body)
        if options:
            combo.addItems(options)
        return cls.widget(combo, **kwargs)

    @classmethod
    def label(cls, title, **kwargs)->QLabel:
        return cls.widget(QLabel(title), **kwargs)

    @classmethod
    def card(cls, **kwargs):
        return cls.widget(QFrame(), **kwargs)

    @classmethod
    def button(cls, title:str, action:Callable|None=None, shortcut=None, **kwargs):
        button = QPushButton(title)
        button.setCursor(Qt.CursorShape.PointingHandCursor) 
        if action: button.clicked.connect(action)
        if shortcut: button.setShortcut(shortcut)
        return cls.widget(button, **kwargs)

    @classmethod
    def input(cls, placeholder="", type="text", **kwargs)->QLineEdit:
        if type == "number":
            widget = QLineEdit()
            widget.setValidator(QIntValidator())
        elif type == "float":
            widget = QLineEdit()
            widget.setValidator(QDoubleValidator())
        elif type == "password":
            widget = QLineEdit()
            widget.setEchoMode(QLineEdit.EchoMode.Password)
        else:  # text par défaut
            widget = QLineEdit()
        
        widget.setPlaceholderText(placeholder)
        return cls.widget(widget, **kwargs)

    @classmethod
    def textarea(cls, placeholder="", **kwargs):
        widget = QTextEdit()
        widget.setPlaceholderText(placeholder)
        return cls.widget(widget, **kwargs)

    @classmethod
    def radio(cls, title, **kwargs):
        return cls.widget(QRadioButton(title), **kwargs)

    @classmethod
    def checkbox(cls, title, **kwargs):
        return cls.widget(QCheckBox(title), **kwargs)

    @classmethod
    def slider(cls, orientation=Qt.Orientation.Horizontal, **kwargs):
        widget = QSlider(orientation)
        return cls.widget(widget, **kwargs)

    @classmethod
    def spinbox(cls, **kwargs):
        widget = QSpinBox()
        return cls.widget(widget, **kwargs)

    @classmethod
    def doublespinbox(cls, **kwargs):
        widget = QDoubleSpinBox()
        return cls.widget(widget, **kwargs)

    @classmethod
    def progress(cls, **kwargs):
        widget = QProgressBar(kwargs.get("parent", cls.body))
        widget.setMinimum(kwargs.get("min", 0))
        widget.setMaximum(kwargs.get("max", 100))
        widget.setValue(kwargs.get("value", 0))
        return cls.widget(widget, **kwargs)

    @classmethod
    def image(cls, path, **kwargs):
        image = QLabel()
        pixmap = QPixmap(path)
        image.setPixmap(pixmap)
        image.setScaledContents(True)
        return cls.widget(image, **kwargs)

    @classmethod
    def table(cls, data: list, **kwargs):
        if not data:
            return None
        headers = list(data[0].keys())
        table = QTableWidget(len(data), len(headers))
        table.setHorizontalHeaderLabels(headers)
        for row_idx, row_data in enumerate(data):
            for col_idx, key in enumerate(headers):
                table.setItem(row_idx, col_idx, QTableWidgetItem(str(row_data[key])))
        return cls.widget(table, **kwargs)

    @classmethod
    def tree(cls, data: dict, **kwargs):
        tree = QTreeWidget()
        tree.setHeaderLabels(["Name", "Value"])
        for key, value in data.items():
            parent = QTreeWidgetItem([str(key), ""])
            if isinstance(value, dict):
                for k, v in value.items():
                    QTreeWidgetItem(parent, [str(k), str(v)])
            else:
                QTreeWidgetItem(parent, ["", str(value)])
            tree.addTopLevelItem(parent)
        return cls.widget(tree, **kwargs)

    @classmethod
    def list(cls, items: list, **kwargs):
        lst = QListWidget()
        for i in items:
            QListWidgetItem(str(i), lst)
        return cls.widget(lst, **kwargs)

    @classmethod
    def scrollbar(cls, orientation=Qt.Orientation.Vertical, **kwargs):
        bar = QScrollBar(orientation)
        return cls.widget(bar, **kwargs)

    # ---------- Boîtes de dialogue ----------
    @classmethod
    def file(cls, mode="open"):
        if mode == "open":
            return QFileDialog.getOpenFileName(cls.window, "Open File")[0]
        elif mode == "save":
            return QFileDialog.getSaveFileName(cls.window, "Save File")[0]
        return None 

    # ---------- Menus / Toolbars ----------
    @classmethod
    def menu(cls, title):
        return cls.window.menuBar().addMenu(title)  #type:ignore

    @classmethod
    def action(cls, title, parent=None, trigger=None, icon=None):
        act = QAction(title, parent or cls.window)
        if icon:
            act.setIcon(QIcon(icon))
        if trigger:
            act.triggered.connect(trigger)
        return act

    @classmethod
    def toolbar(cls, title="Toolbar"):
        bar = QToolBar(title)
        cls.window.addToolBar(bar)
        return bar

    @classmethod
    def status(cls, message):
        cls.window.statusBar().showMessage(message) #type:ignore 

     # ---------- Widgets avancés ----------
    @classmethod
    def tab(cls, tabs: dict, **kwargs): 
        widget = QTabWidget()
        for title, content in tabs.items():
            widget.addTab(content, title)
        return cls.widget(widget, **kwargs)

    @classmethod
    def scroll(cls, widget: QWidget, **kwargs): 
        scroll = QScrollArea()
        scroll.setWidget(widget)
        scroll.setWidgetResizable(True)
        return scroll 

    @classmethod
    def scene(cls):
        scene = QGraphicsScene()
        return scene


    @classmethod
    def canvas(cls, pixmap_path=None, scene: QGraphicsScene=None, **kwargs): 
        if scene is None:
            scene = QGraphicsScene()
            if pixmap_path:
                pix = QPixmap(pixmap_path)
                item = QGraphicsPixmapItem(pix)
                scene.addItem(item)

        view = QGraphicsView(scene)
        view.setDragMode(QGraphicsView.DragMode.ScrollHandDrag)  # déplacement
        view.setTransformationAnchor(QGraphicsView.ViewportAnchor.AnchorUnderMouse)
        return cls.widget(view, **kwargs)

    @classmethod
    def splitter(cls, widgets, orientation=Qt.Orientation.Horizontal, **kwargs): 
        split = QSplitter(orientation)
        for w in widgets:
            split.addWidget(w)
        return cls.widget(split, **kwargs)
    
    @classmethod
    def alert(cls, text, type="info", title=None): 
        msg = QMessageBox()
        
        type = type.lower()
        if type == "info":
            msg.setIcon(QMessageBox.Icon.Information)
            msg.setWindowTitle(title or "Information")
        elif type == "warning":
            msg.setIcon(QMessageBox.Icon.Warning)
            msg.setWindowTitle(title or "Warning")
        elif type == "error":
            msg.setIcon(QMessageBox.Icon.Critical)
            msg.setWindowTitle(title or "Error")
        elif type == "success": 
            msg.setIcon(QMessageBox.Icon.Information)
            msg.setWindowTitle(title or "Success")
        else:
            msg.setIcon(QMessageBox.Icon.NoIcon)
            msg.setWindowTitle(title or "Alert")
        
        msg.setText(text)
        msg.exec()


    # ---------- Start ----------
    @classmethod
    def start(cls): 
        if cls.running:
            return cls
        cls.running = True
        cls.window.show()
        sys.exit(cls.app.exec())