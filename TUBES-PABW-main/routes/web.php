<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuatLaporanController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;


// Public berita pages
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{berita}', [BeritaController::class, 'show'])->name('berita.show');
Route::post('/berita/{berita}/like', [BeritaController::class, 'like'])->name('berita.like')->middleware('auth');
Route::post('/berita/{berita}/comment', [BeritaController::class, 'commentStore'])->name('berita.comment')->middleware('auth');

/*
|--------------------------------------------------------------------------
| DEFAULT
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| AUTH (LOGIN, REGISTER, LOGOUT)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ROUTE SETELAH LOGIN
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // HOME
    // Route::get('/home', fn () => view('home'))->name('home');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // BUAT LAPORAN
    Route::get('/buatlaporan', [BuatLaporanController::class, 'form'])
        ->name('buatlaporan');

    Route::post('/buatlaporan', [BuatLaporanController::class, 'simpan'])
        ->name('buatlaporan.simpan');

    // FEEDBACK
    Route::post('/feedback', [FeedbackController::class, 'store'])
        ->name('feedback.store');

    // LAPORAN SAYA (PER USER)
    Route::get('/laporansaya', [BuatLaporanController::class, 'index'])
        ->name('laporansaya');

    // HALAMAN LAIN
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi');
    Route::get('/kotaktinjauan', function () {return view('kotaktinjauan');})->name('kotaktinjauan');

    Route::middleware('isAdmin')->group(function () {

        Route::get('/admin/laporan', [AdminController::class, 'index'])
            ->name('admin.laporan');

        Route::post('/admin/laporan/{id}/status', [AdminController::class, 'updateStatus'])
            ->name('admin.laporan.status');

        Route::get('/admin/statistik', [AdminController::class, 'statistik'])
            ->name('admin.statistik')
            ->middleware(['auth','isAdmin']);
        
        Route::get('/admin/feedback', [AdminController::class, 'feedback'])
            ->name('admin.feedback');

        // Admin berita management
        Route::get('/admin/berita', [AdminBeritaController::class, 'index'])->name('admin.berita.index');
        Route::get('/admin/berita/create', [AdminBeritaController::class, 'create'])->name('admin.berita.create');
        Route::post('/admin/berita', [AdminBeritaController::class, 'store'])->name('admin.berita.store');
        Route::get('/admin/berita/{berita}', [AdminBeritaController::class, 'show'])->name('admin.berita.show');
        Route::get('/admin/berita/{berita}/edit', [AdminBeritaController::class, 'edit'])->name('admin.berita.edit');
        Route::put('/admin/berita/{berita}', [AdminBeritaController::class, 'update'])->name('admin.berita.update');
        Route::post('/admin/berita/{berita}/publish', [AdminBeritaController::class, 'publish'])->name('admin.berita.publish');
        Route::post('/admin/berita/{berita}/takedown', [AdminBeritaController::class, 'takedown'])->name('admin.berita.takedown');
        Route::post('/admin/berita/{berita}/draft', [AdminBeritaController::class, 'restoreDraft'])->name('admin.berita.draft');
        Route::delete('/admin/berita/{berita}', [AdminBeritaController::class, 'destroy'])->name('admin.berita.destroy');
    });

});


