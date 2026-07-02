<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::view('game', 'game')->name('game');
// });

Route::get('/media/{path}', function (string $path) {
    abort_unless(Storage::disk('public')->exists($path), 404);
    return Storage::disk('public')->response($path);
})->where('path', '.*')->name('media');

require __DIR__.'/settings.php';
