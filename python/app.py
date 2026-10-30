
from fastapi import FastAPI, HTTPException
from pydantic import BaseModel
import pickle
import os
import pandas as pd
import uvicorn

app = FastAPI(
    title="API Prediksi Kelayakan Mutasi PNS",
    version="1.0.0"
)

BASE_DIR = os.path.dirname(os.path.abspath(__file__))
MODEL_PATH = os.path.join(BASE_DIR, "model_xgboost_mutasi.pkl")

# Definisikan kolom fitur secara manual
FEATURE_COLUMNS = [
    "Masa_Kerja",
    "Hasil_Kerja_Di Bawah Ekspektasi",
    "Hasil_Kerja_Sesuai Ekspektasi",
    "Perilaku_Kerja_Di Bawah Ekspektasi",
    "Perilaku_Kerja_Sesuai Ekspektasi",
    "Kelengkapan_Berkas_Tidak Lengkap",
    "Sedang_Hukuman_Disiplin_Ya",
    "Bebas_Temuan_Inspektorat_Ya",
    "Sedang_Tugas_Belajar_Ya",
    "Kesesuaian_Formasi_ABK_Tidak Sesuai"
]
model = None


def load_model():
    global model

    try:
        print("Mencari model:", MODEL_PATH)

        if not os.path.exists(MODEL_PATH):
            raise FileNotFoundError("File model tidak ditemukan!")

        with open(MODEL_PATH, "rb") as f:
            model = pickle.load(f)

        print("Model XGBoost berhasil dimuat!")
        print("Tipe model:", type(model))

        return True

    except Exception as e:
        print("Gagal memuat model:", str(e))
        model = None
        return False


load_model()


class PrediksiInput(BaseModel):
    data: dict


@app.get("/")
def home():
    return {
        "status": "success",
        "message": "API Prediksi Mutasi PNS aktif"
    }


@app.post("/prediksi")
def prediksi(input_data: PrediksiInput):

    if model is None:
        raise HTTPException(
            status_code=500,
            detail="Model belum berhasil dimuat"
        )

    try:
        # Membuat DataFrame dari JSON
        df_input = pd.DataFrame([input_data.data])

        # Memeriksa fitur wajib
        missing_columns = [
            col for col in FEATURE_COLUMNS
            if col not in df_input.columns
        ]

        if missing_columns:
            raise HTTPException(
                status_code=422,
                detail={
                    "message": "Fitur wajib belum lengkap",
                    "missing_features": missing_columns
                }
            )

        # Mengatur urutan fitur
        df_input = df_input[FEATURE_COLUMNS]

        # Memeriksa nilai kosong
        if df_input.isnull().any().any():
            raise HTTPException(
                status_code=422,
                detail="Semua fitur wajib memiliki nilai"
            )

        # Memastikan fitur biner bernilai 0 atau 1
        for col in FEATURE_COLUMNS:
            if col != "Masa_Kerja":
                value = df_input.iloc[0][col]

                if value not in [0, 1, False, True]:
                    raise HTTPException(
                        status_code=422,
                        detail=f"Fitur {col} harus bernilai 0 atau 1"
                    )

        # Konversi tipe data agar sama persis dengan X_train di Google Colab
        for col in FEATURE_COLUMNS:
            if col == "Masa_Kerja":
        # Hanya Masa_Kerja yang bertipe numerik (integer)
                df_input[col] = df_input[col].astype(int)
            else:
        # Sisanya wajib dikonversi menjadi tipe boolean (True/False)
                df_input[col] = df_input[col].astype(bool)

        # Prediksi kelas
        pred_res = model.predict(df_input)

        # Prediksi probabilitas
        proba = model.predict_proba(df_input)

        label = int(pred_res[0])

        hasil = "Layak" if label == 1 else "Tidak Layak"

        # Mengambil probabilitas berdasarkan kelas
        probabilitas = {
            int(kelas): float(nilai)
            for kelas, nilai in zip(model.classes_, proba[0])
        }

        prob_tidak = probabilitas.get(0, 0.0)
        prob_layak = probabilitas.get(1, 0.0)

        prob_prediksi = probabilitas.get(label, 0.0)
        prob_prediksi_persen = round(prob_prediksi * 100, 2)

        return {
            "status": "success",
            "hasil_prediksi": hasil,
            "label": label,
            "probabilitas_persen": prob_prediksi_persen,
            "probabilitas": {
                "tidak_layak": prob_tidak,
                "layak": prob_layak
            },
            "input": input_data.data
        }

    except HTTPException:
        raise

    except Exception as e:
        raise HTTPException(
            status_code=400,
            detail=str(e)
        )


if __name__ == "__main__":
    uvicorn.run(
        app,
        host="127.0.0.1",
        port=8001,
        log_level="info"
    )
