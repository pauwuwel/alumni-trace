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
            Route::get('/print', [DashboardController::class, 'printPDF']);
        });

        Route::prefix('profile')->group(function () {
            Route::get('/{id}', [ProfileController::class, 'index']);
            Route::get('/print/{id}', [ProfileController::class, 'printPDF']);
            Route::get('/edit/{id}', [ProfileController::class, 'edit']);
            Route::post('/edit/{id}', [ProfileController::class, 'update']);
            Route::post('/{id}', [ProfileController::class, 'addKarir']);
            Route::post('/edit-karir/{id}', [ProfileController::class, 'editKarir']);
            Route::delete('/{id}', [ProfileController::class, 'removeKarir']);
            Route::get('/{id}/activity', [ProfileController::class, 'showLogs']);
            Route::get('/{id}/forum', [ProfileController::class, 'showForum']);
        });

    });

    Route::middleware(['access:superAdmin'])->group(function () {

        Route::prefix('kelola-akun')->group(function () {
            Route::get('/', [AkunController::class, 'index']);
            // Route::get('/tambah', [AkunController::class, 'create']);
            Route::post('/tambah', [AkunController::class, 'store']);
            // Route::get('/edit/{id}', [AkunController::class, 'edit']);
            Route::post('/edit/{id}', [AkunController::class, 'update']);
            Route::delete('/hapus', [AkunController::class, 'destroy']);
        });

    });

    Route::middleware(['access:admin,alumni'])->group(function () {

        Route::prefix('forum')->group(function () {
            Route::get('/', [ForumController::class, 'index']);
            Route::get('/tambah', [ForumController::class, 'create']);
            Route::post('/tambah', [ForumController::class, 'store']);
            Route::get('/post/{id}', [ForumController::class, 'show']);
            Route::get('/cetak/{id}', [ForumController::class, 'cetak']);
            Route::post('/status', [ForumController::class, 'status']);
            Route::get('/edit/{id}', [ForumController::class, 'edit']);
            Route::post('/edit/{id}', [ForumController::class, 'update']);
            Route::post('/hapus', [ForumController::class, 'destroy']);
            Route::delete('/hapus-komen', [ForumController::class, 'remove']);
            Route::post('/add-komentar', [ForumController::class, 'addKomen']);
            Route::post('/add-komentar', [ForumController::class, 'addKomen']);
            Route::get('/search-forum', [ForumController::class, 'search']);
            Route::get('/print-pdf/{id}', [ForumController::class, 'cetak']);
        });

    });

    Route::middleware(['access:alumni'])->group(function () {

        Route::prefix('galeri')->group(function () {
            Route::get('/', [GalleryController::class, 'index']);
            Route::get('/search-alumni', [GalleryController::class, 'search']);
        });

    });

    Route::get('/logout', [AuthController::class, 'loggingout']);
});
