import sys
from typing import Any
try:
    from PyQt6.QtWidgets import (
        QApplication, QMainWindow, QWidget, QFrame, QLabel,
        QPushButton, QLineEdit, QCheckBox, QRadioButton, QSlider,
        QDialog, QProgressBar, QComboBox, QTableWidget, QTableWidgetItem,
        QTreeWidget, QTreeWidgetItem, QTextEdit, QListWidget, QListWidgetItem,
        QSpinBox, QDoubleSpinBox, QScrollBar, QFileDialog, QColorDialog,
        QMessageBox, QToolBar, QStatusBar, QGraphicsView, QGraphicsScene, QGraphicsPixmapItem, QTabWidget, QScrollArea, QSplitter

    )
    from PyQt6.QtCore import Qt
    from PyQt6.QtGui import QIcon, QPixmap, QAction
except ImportError:
    pass


class Interface:

    def __init__(self, **kwargs):
        self.app = QApplication(sys.argv)
        self.window = QMainWindow()
        self.widgets = []
        self.window.resizeEvent = self.resize_event  # type: ignore

        title = kwargs.get('title', 'Creator')
        self.width = kwargs.get('width', 1200)
        self.height = kwargs.get('height', self.width // 2)
        style = kwargs.get('style', None)
        icon = kwargs.get('icon', None)

        self.window.setWindowTitle(title)
        self.window.resize(self.width, self.height)

        self.body = QWidget()
        self.body.setProperty("class", style)
        self.window.setCentralWidget(self.body)
        if icon:
            self.window.setWindowIcon(QIcon(icon))

        # Status bar par défaut
        self.window.setStatusBar(QStatusBar())

    def styles(self, src) -> None:
        from src.core import File
        self.window.setStyleSheet(File(src).load())

    def responsive(self, width, height):
        scalewidth = self.window.width() / self.width
        scaleheight = self.window.height() / self.height
        return int(width * scalewidth), int(height * scaleheight)

    def resize_event(self, event):
        for item in self.widgets:
            widget: QWidget = item["widget"]
            x, y = item["position"]
            width, height = item["size"]
            if width and height:
                widget.resize(*self.responsive(width, height))
            widget.move(*self.responsive(x, y))
        event.accept()

    def add(self, widget: 'QWidget', **kwargs):
        parent: QWidget = kwargs.get("parent", self.body)
        position = kwargs.get("position", (0, 0))
        size = kwargs.get("size", (parent.width(), parent.height()))
        style = kwargs.get("style", None)

        widget.setParent(parent)
        widget.move(*position)
        widget.resize(*size)
        widget.setProperty("class", style)

        minwidth = kwargs.get("minwidth", False)
        min_heigth = kwargs.get("min_heigth", False)
        maxwidth = kwargs.get("maxwidth", False)
        max_heigth = kwargs.get("max_heigth", False)

        if minwidth:
            widget.setMinimumWidth(minwidth)
        if min_heigth:
            widget.setMinimumHeight(min_heigth)
        if maxwidth:
            widget.setMaximumWidth(maxwidth)
        if max_heigth:
            widget.setMaximumHeight(max_heigth)

        self.widgets.append({
            "widget": widget,
            "position": position,
            "size": size,
        })
        return widget

    # ---------- Widgets ----------
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
        if options:
            combo.addItems(options)
        return self.add(combo, **kwargs)

    def label(self, title, **kwargs):
        return self.add(QLabel(title), **kwargs)

    def card(self, **kwargs):
        return self.add(QFrame(), **kwargs)

    def button(self, title, action=None, **kwargs):
        button = QPushButton(title)
        if action:
            button.clicked.connect(action)
        return self.add(button, **kwargs)

    def input(self, placeholder="", **kwargs):
        widget = QLineEdit()
        widget.setPlaceholderText(placeholder)
        return self.add(widget, **kwargs)

    def textarea(self, placeholder="", **kwargs):
        widget = QTextEdit()
        widget.setPlaceholderText(placeholder)
        return self.add(widget, **kwargs)

    def radio(self, title, **kwargs):
        return self.add(QRadioButton(title), **kwargs)

    def checkbox(self, title, **kwargs):
        return self.add(QCheckBox(title), **kwargs)

    def slider(self, orientation=Qt.Orientation.Horizontal, **kwargs):
        widget = QSlider(orientation)
        return self.add(widget, **kwargs)

    def spinbox(self, **kwargs):
        widget = QSpinBox()
        return self.add(widget, **kwargs)

    def doublespinbox(self, **kwargs):
        widget = QDoubleSpinBox()
        return self.add(widget, **kwargs)

    def progress(self, **kwargs):
        widget = QProgressBar(kwargs.get("parent", self.body))
        widget.setMinimum(kwargs.get("min", 0))
        widget.setMaximum(kwargs.get("max", 100))
        widget.setValue(kwargs.get("value", 0))
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

    def tree(self, data: dict, **kwargs):
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
        return self.add(tree, **kwargs)

    def list(self, items: list, **kwargs):
        lst = QListWidget()
        for i in items:
            QListWidgetItem(str(i), lst)
        return self.add(lst, **kwargs)

    def scrollbar(self, orientation=Qt.Orientation.Vertical, **kwargs):
        bar = QScrollBar(orientation)
        return self.add(bar, **kwargs)

    # ---------- Boîtes de dialogue ----------
    def file_dialog(self, mode="open"):
        if mode == "open":
            return QFileDialog.getOpenFileName(self.window, "Open File")[0]
        elif mode == "save":
            return QFileDialog.getSaveFileName(self.window, "Save File")[0]
        return None

    def color_dialog(self):
        return QColorDialog.getColor()

    def message(self, text, title="Info"):
        msg = QMessageBox()
        msg.setIcon(QMessageBox.Icon.Information)
        msg.setWindowTitle(title)
        msg.setText(text)
        msg.exec()

    # ---------- Menus / Toolbars ----------
    def menu(self, title):
        return self.window.menuBar().addMenu(title)  #type:ignore

    def action(self, title, parent=None, trigger=None, icon=None):
        act = QAction(title, parent or self.window)
        if icon:
            act.setIcon(QIcon(icon))
        if trigger:
            act.triggered.connect(trigger)
        return act

    def toolbar(self, title="Toolbar"):
        bar = QToolBar(title)
        self.window.addToolBar(bar)
        return bar

    def status(self, message):
        self.window.statusBar().showMessage(message) #type:ignore 

     # ---------- Widgets avancés ----------
    def tab(self, tabs: dict, **kwargs): 
        widget = QTabWidget()
        for title, content in tabs.items():
            widget.addTab(content, title)
        return self.add(widget, **kwargs)

    def scroll_area(self, widget: QWidget, **kwargs): 
        scroll = QScrollArea()
        scroll.setWidget(widget)
        scroll.setWidgetResizable(True)
        return self.add(scroll, **kwargs)

    def graphics_view(self, pixmap_path=None, scene: QGraphicsScene=None, **kwargs): 
        if scene is None:
            scene = QGraphicsScene()
            if pixmap_path:
                pix = QPixmap(pixmap_path)
                item = QGraphicsPixmapItem(pix)
                scene.addItem(item)

        view = QGraphicsView(scene)
        view.setDragMode(QGraphicsView.DragMode.ScrollHandDrag)  # déplacement
        view.setTransformationAnchor(QGraphicsView.ViewportAnchor.AnchorUnderMouse)
        return self.add(view, **kwargs)

    def splitter(self, widgets, orientation=Qt.Orientation.Horizontal, **kwargs): 
        split = QSplitter(orientation)
        for w in widgets:
            split.addWidget(w)
        return self.add(split, **kwargs)

    # ---------- Start ----------
    def start(self):
        self.window.show()
        sys.exit(self.app.exec())