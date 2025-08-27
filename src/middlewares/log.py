class LogMiddleware:
    def handle(self, request, next):
        print(f"[LOG] {request}")
        response = next(request)
        print(f"[LOG RESPONSE] {response}")
        return response