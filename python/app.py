
from fastapi import FastAPI
import uvicorn

app = FastAPI(title="Machine Learning API")


@app.get("/health")
def health():
    return {
        "status": "success",
        "message": "Python ML API aktif"
    }


if __name__ == "__main__":
    uvicorn.run(
        app,
        host="127.0.0.1",
        port=8001,
        log_level="info"
    )
