from pprint import pprint
import sys 

class Debug: 
    @staticmethod
    def dump(*args):
        print(args)

    @staticmethod
    def dd(*args):
        for a in args:
            pprint(a)
        sys.exit(1)
