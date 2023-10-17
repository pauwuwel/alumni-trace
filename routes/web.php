<?php

use App\Http\Controllers\AkunController;
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

    Route::get('/', function() {
        return view('welcome');
    });

    Route::prefix('dashboard')->middleware(['access:admin'])->group(function () {
        Route::get('/', function() {
            return view('welcome');
        });
    });

    Route::get('/logout', [AuthController::class, 'logout']);
});