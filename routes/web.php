<?php

use App\Http\Controllers\Guest;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Custom Routes
    Route::post('/upload', [Guest::class, 'import'])->name('upload');
    Route::get('/search', [Guest::class, 'search'])->name('search');
    Route::get('/search-guests', [Guest::class, 'searchGuests'])->name('search-guests');
});

require __DIR__.'/auth.php';
