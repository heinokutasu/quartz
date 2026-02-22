<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;


Route::get('/', function () {
    return view('index');
});

Route::prefix('portal')->group(function () {
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('home');
    Route::post('/upload', [AttendanceController::class, 'upload'])->name('upload');
    Route::get('/report', [AttendanceController::class, 'report'])->name('report');
});
