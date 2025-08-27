class Handle: 
     
    @classmethod
    def request(cls, uri, injector):
        pass

    @classmethod
    def error(cls):
        pass

    @staticmethod
    def exception(terminal: 'Terminal', error): 
        raise Exception(terminal.error(f"{str(error)}"))