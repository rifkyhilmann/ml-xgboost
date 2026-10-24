<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HasilPrediksiController;
use App\Http\Controllers\KelolaPegawaiController;
use App\Http\Controllers\KelolaUsersController;
use App\Http\Controllers\PrediksiController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('kelola-pengguna', KelolaUsersController::class);
    Route::resource('kelola-pegawai', KelolaPegawaiController::class);

    Route::get('/prediksi', [PrediksiController::class, 'index'])->name('prediksi');
    Route::get('/hasil-prediksi', [HasilPrediksiController::class, 'index'])->name('hasil-prediksi');
});