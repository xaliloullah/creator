from src.environment import env
 

name = env('SESSION_NAME', 'sessions')
driver = env('SESSION_DRIVER', 'file')
lifetime = env('SESSION_LIFETIME', 30)
expire_on_close = env('SESSION_EXPIRE_ON_CLOSE', False)
encrypt = env('SESSION_ENCRYPT', True) 