<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Carbon;

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

    Route::middleware(['access:admin,superAdmin,alumni'])->group(function () {

        Route::prefix('dashboard')->group(function () {
            Route::get('/', [DashboardController::class, 'index']);
        });

        Route::prefix('profile')->group(function () {
            Route::get('/{id}', [ProfileController::class, 'index']);
            Route::get('/edit/{id}', [ProfileController::class, 'edit']);
            Route::post('/edit/{id}', [ProfileController::class, 'update']);
            // Route::post('/edit/simpan', [ProfileController::class, 'update']);
        });

    });

    Route::middleware(['access:superAdmin'])->group(function () {

        Route::prefix('kelola-akun')->group(function () {
            Route::get('/', [AkunController::class, 'index']);
            Route::get('/tambah', [AkunController::class, 'create']);
            Route::post('/tambah', [AkunController::class, 'store']);
            Route::get('/edit/{id}', [AkunController::class, 'edit']);
            Route::post('/edit/{id}', [AkunController::class, 'update']);
            Route::delete('/hapus', [AkunController::class, 'destroy']);
        });

    });

    Route::middleware(['access:admin,alumni'])->group(function () {

        Route::prefix('forum')->group(function () {
            Route::get('/', [ForumController::class, 'index']);
            Route::get('/tambah', [ForumController::class, 'create']);
            Route::post('/tambah', [ForumController::class, 'store']);
            Route::get('/{id}', [ForumController::class, 'show']);
            Route::get('/edit/{id}', [ForumController::class, 'edit']);
            Route::post('/edit/{id}', [ForumController::class, 'update']);
            Route::delete('/hapus', [ForumController::class, 'destroy']);
        });

    });

    Route::middleware(['access:alumni'])->group(function () {

        Route::prefix('galeri')->group(function () {
            Route::get('/', [GalleryController::class, 'index']);
        });

    });

    Route::get('/logout', [AuthController::class, 'loggingout']);
});
