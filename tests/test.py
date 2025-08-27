from src.core import Collection  # notre classe de base
from src.core.test import Test  

# tests/test_session.py 

class SessionTest(Test):

    def test_create_and_destroy(self):
        self.session.create(user_id=42)
        self.assertSessionHas("user_id")
        self.assertEqual(self.session.get("user_id"), 42)

        self.session.destroy()
        self.assertSessionMissing("user_id")
