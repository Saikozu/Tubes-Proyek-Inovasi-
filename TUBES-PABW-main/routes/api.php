<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BeritaApiController;
use App\Http\Controllers\Api\LaporanApiController;
use App\Http\Controllers\Api\FeedbackApiController;
use App\Http\Controllers\Api\NotificationApiController;
use App\Http\Controllers\Api\AuthApiController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Auth
Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/register', [AuthApiController::class, 'register']);
Route::middleware('auth:sanctum')->post('/logout', [AuthApiController::class, 'logout']);

// Berita
Route::get('/berita', [BeritaApiController::class, 'index']);
Route::get('/berita/{berita}', [BeritaApiController::class, 'show']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/berita/{berita}/like', [BeritaApiController::class, 'like']);
    Route::post('/berita/{berita}/comment', [BeritaApiController::class, 'comment']);
});

// Laporan
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/laporan', [LaporanApiController::class, 'index']);
    Route::post('/laporan', [LaporanApiController::class, 'store']);
    Route::get('/laporan/{laporan}', [LaporanApiController::class, 'show']);
    Route::put('/laporan/{laporan}', [LaporanApiController::class, 'update']);
    Route::delete('/laporan/{laporan}', [LaporanApiController::class, 'destroy']);
});

// Feedback
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/feedback', [FeedbackApiController::class, 'index']);
    Route::post('/feedback', [FeedbackApiController::class, 'store']);
});

// Notification
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/notifications', [NotificationApiController::class, 'index']);
    Route::post('/notifications/{notification}/read', [NotificationApiController::class, 'markAsRead']);
});