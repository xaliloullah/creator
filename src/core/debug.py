import sys

class Debug:
    def __init__(self, *args):
        self.args = args  

    def dd(self, exit_code=1):
        self.dump()
        sys.exit(exit_code)


    def dump(self):
        print(self.args)     

