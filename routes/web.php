<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

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
    return redirect('login');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loggingin']);

Route::middleware(['auth'])->group(function () {

    Route::prefix('dashboard')->middleware(['access:admin,superAdmin,alumni'])->group(function () {
        Route::get('/', [DashboardController::class, 'index']);
    });

    Route::prefix('kelola-akun')->middleware(['access:superAdmin'])->group(function () {
        Route::get('/', [AkunController::class, 'index']);
        Route::get('/tambah', [AkunController::class, 'create']);
        Route::post('/tambah', [AkunController::class, 'store']);
    });

    Route::get('/logout', [AuthController::class, 'loggingout']);
});