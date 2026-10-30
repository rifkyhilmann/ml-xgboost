from fastapi import FastAPI, HTTPException
from pydantic import BaseModel
import pickle
import os
import pandas as pd
import numpy as np

app = FastAPI(title="API Prediksi Kelayakan Mutasi PNS", version="1.0.0")

MODEL_PATH = os.path.join(os.path.dirname(__file__), "model_xgboost_mutasi.pkl")
COLUMNS_PATH = os.path.join(os.path.dirname(__file__), "kolom_fitur_mutasi.pkl")

# Load model and columns
try:
    with open(MODEL_PATH, "rb") as f:
        model = pickle.load(f)
    with open(COLUMNS_PATH, "rb") as f:
        FEATURE_COLUMNS = pickle.load(f)
    print("Model dan kolom fitur berhasil dimuat")
except Exception as e:
    model = None
    FEATURE_COLUMNS = []
    print(f"Error loading model/columns: {e}")

class PrediksiInput(BaseModel):
    data: dict

@app.get("/health")
def health():
    return {
        "status": "success",
        "message": "API Prediksi Mutasi aktif",
        "model_loaded": model is not None,
        "jumlah_fitur": len(FEATURE_COLUMNS),
        "fitur": FEATURE_COLUMNS
    }

@app.get("/fitur")
def get_fitur():
    if not FEATURE_COLUMNS:
        raise HTTPException(status_code=500, detail="Kolom fitur tidak berhasil dimuat")
    return {
        "status": "success",
        "fitur": FEATURE_COLUMNS
    }

@app.post("/prediksi")
def prediksi(input_data: PrediksiInput):
    if model is None or not FEATURE_COLUMNS:
        raise HTTPException(status_code=500, detail="Model atau kolom fitur belum dimuat")
    
    try:
        df_input = pd.DataFrame([input_data.data])
        
        for col in FEATURE_COLUMNS:
            if col not in df_input.columns:
                df_input[col] = 0
        
        df_input = df_input[FEATURE_COLUMNS]
        
        prediksi_res = model.predict(df_input)
        probabilitas = model.predict_proba(df_input)
        
        hasil = "Layak" if prediksi_res[0] == 1 else "Tidak Layak"
        prob_layak = float(probabilitas[0][1]) if len(probabilitas[0]) > 1 else float(prediksi_res[0])
        prob_tidak_layak = float(probabilitas[0][0]) if len(probabilitas[0]) > 1 else float(1 - prediksi_res[0])
        
        return {
            "status": "success",
            "hasil_prediksi": hasil,
            "label": int(prediksi_res[0]),
            "probabilitas": {
                "tidak_layak": prob_tidak_layak,
                "layak": prob_layak,
            },
            "input": input_data.data
        }
    except Exception as e:
        raise HTTPException(status_code=400, detail=f"Error saat prediksi: {str(e)}")

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="127.0.0.1", port=8001, log_level="info")
