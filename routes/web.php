<?php

use App\Http\Controllers\AkunController;
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

Route::get('/login', [AkunController::class, 'index'])->name('login');
Route::post('/login', [AkunController::class, 'login']);

Route::middleware(['auth'])->group(function () {

    Route::prefix('dashboard')->middleware(['access:admin,superAdmin,alumni'])->group(function () {
        Route::get('/', [DashboardController::class, 'index']);
    });

    Route::get('/logout', [AkunController::class, 'logout']);
});