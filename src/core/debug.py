import sys 

class Debug: 
    printer=print

    def __init__(self, *args, exit: bool = False, step: bool = False):
        if step:
            for arg in args:
                self.printer(arg)
                input("Press Enter to continue...")
        else:
            self.printer(*args)
        if exit:
            sys.exit(1)