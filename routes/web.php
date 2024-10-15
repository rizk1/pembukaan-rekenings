<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PembukaanRekeningController;
use App\Http\Controllers\PekerjaanController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('pembukaan-rekening.index');
});

Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return "Database connection successful!";
    } catch (\Exception $e) {
        return "Database connection failed: " . $e->getMessage();
    }
});

Auth::routes();

Route::post('/login', [AuthController::class, 'loginProcess'])->name('login');
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('pembukaan-rekening', PembukaanRekeningController::class);
Route::resource('pekerjaan', PekerjaanController::class);
Route::resource('users', UserController::class);
Route::put('users/{id}/change-status', [UserController::class, 'changeStatus'])->name('users.change-status');

Route::middleware(['auth', 'role.spv'])->group(function () {
    Route::post('pembukaan-rekening/{id}/approve', [PembukaanRekeningController::class, 'approve'])->name('pembukaan-rekening.approve');
});
