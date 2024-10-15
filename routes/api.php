<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LocationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('location')->group(function () {
    Route::get('/provinsi',[LocationController::class,'getProvinsi'])->name('api.provinsi');
    Route::get('/kota/{provinsi_id}',[LocationController::class,'getKota'])->name('api.kota');
    Route::get('/kecamatan/{kota_id}',[LocationController::class,'getKecamatan'])->name('api.kecamatan');
    Route::get('/kelurahan/{kecamatan_id}',[LocationController::class,'getKelurahan'])->name('api.kelurahan');
});