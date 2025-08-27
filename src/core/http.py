try:
    import requests
except ImportError:
    requests = None


class Http:
    def __init__(self):
        if requests is None:
            raise ImportError("Le module 'requests' n'est pas installé.")

    def get(self, url, **kwargs):
        return requests.get(url, **kwargs)

    def post(self, url, **kwargs):
        return requests.post(url, **kwargs)

    def put(self, url, **kwargs):
        return requests.put(url, **kwargs)

    def delete(self, url, **kwargs):
        return requests.delete(url, **kwargs)
