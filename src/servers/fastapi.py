# from fastapi import FastAPI
# from fastapi.responses import JSONResponse

# app = FastAPI()

# # Fonction qui sera appelée pour cette route
# def hello():
#     return JSONResponse(content={"message": "Hello FastAPI!"})

# # Ajout manuel de la route
# app.add_api_route("/hello", hello, methods=["GET"])

# # Une autre route avec paramètre
# def greet(name: str):
#     return JSONResponse(content={"message": f"Hello {name}!"})

# app.add_api_route("/greet/{name}", greet, methods=["GET"])
