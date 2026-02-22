<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;

Route::get('/', [AttendanceController::class, 'index'])->name('home');
Route::post('/upload', [AttendanceController::class, 'upload'])->name('upload');

// Separate Report Page
Route::get('/report', [AttendanceController::class, 'report'])->name('report');
