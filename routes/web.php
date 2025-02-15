<?php

use App\Http\Controllers\Guest;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {

    if (request()->user()->role === 'admin') {
        return view('dashboard');
    } elseif (request()->user()->role === 'searcher') {
        return redirect()->route('search');
    } else {
        return redirect()->route('incoming-guests');
    }

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Custom Routes
    Route::post('/upload', [Guest::class, 'import'])->name('upload');
    Route::get('/search', [Guest::class, 'search'])->name('search');
    Route::get('/search-guests', [Guest::class, 'searchGuests'])->name('search-guests');
    Route::get('/confirm-guest', [Guest::class, 'confirmGuest'])->name('confirm-guest');
    Route::get('/de-confirm-guest', [Guest::class, 'deConfirmGuest'])->name('de-confirm-guest');
    Route::get('/edit-guest/{guest}', [Guest::class, 'editGuest'])->name('edit-guest');
    Route::put('/edit-guest-details/{guest}', [Guest::class, 'editGuestDetails'])->name('edit-guest-details');
    Route::get('/incoming-guests/{view?}', [Guest::class, 'incomingGuests'])->name('incoming-guests');
    Route::get('/on-seat', [Guest::class, 'onSeat'])->name('on-seat');
    Route::get('/on-seat-guests', [Guest::class, 'onSeatGuests'])->name('on-seat-guests'); // for viewing on seat guests
    Route::get('/revert-guest-status', [Guest::class, 'revertGuestStatus'])->name('revert-guest-status');
});

require __DIR__.'/auth.php';
