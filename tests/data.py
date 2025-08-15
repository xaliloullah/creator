import sys
import os
 
sys.path.append(os.path.abspath(os.path.join(__file__, "..", "..")))

from PyQt5.QtWidgets import QApplication
from PyQt5.QtWebEngineWidgets import QWebEngineView
import sys
from main import Creator
app = QApplication(sys.argv)
web = QWebEngineView()
web.setHtml(Creator.file('tests/index.html', format="html").load())
web.show()
sys.exit(app.exec_())