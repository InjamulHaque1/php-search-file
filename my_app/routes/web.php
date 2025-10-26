<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;

Route::get('/', [FileController::class, 'index'])->name('home');
Route::post('/upload', [FileController::class, 'store'])->name('upload');

Route::get('/search', [FileController::class, 'searchPage'])->name('search.page');
Route::get('/search/files', [FileController::class, 'search'])->name('search.files');

Route::delete('/file/{id}', [FileController::class, 'destroy'])->name('file.delete');
