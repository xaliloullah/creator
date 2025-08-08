class Middleware:
    middlewares = {}

    @classmethod
    def setup(cls):
        try:
            from routes import middleware
        except ImportError:
            raise ImportError("middleware module not found. Please ensure that the middleware are properly defined and imported.")

    @classmethod
    def register(cls, name: str, middleware): 
        cls.middlewares[name] = middleware

    @staticmethod
    def handle(args):
        raise NotImplementedError("Each command must implement 'handle'.")

    @classmethod
    def run(cls, middlewares, handler, *args, **kwargs):
        # cls.setup()

        # def run_next(index):
        #     if index < len(middlewares):
        #         mw = middlewares[index]
        #         # middleware peut être une classe ou un nom enregistré
        #         if isinstance(mw, str):
        #             mw_cls = cls.middlewares.get(mw)
        #             if not mw_cls:
        #                 raise ValueError(f"Middleware '{mw}' is not registered.")
        #         else:
        #             mw_cls = mw

        #         # Instanciation du middleware
        #         mw_instance = mw_cls()

        #         # Appel de la méthode handle avec les arguments + next
        #         return mw_instance.handle(*args, next=lambda *a, **kw: run_next(index + 1), **kwargs)
        #     else:
        #         # Tous les middlewares exécutés => appel du handler final
        #         return handler(*args, **kwargs)

        # return run_next(0)

        handler()