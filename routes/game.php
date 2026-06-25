<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
        Route::livewire('play', 'pages::play')->name('play');
});

require __DIR__.'/settings.php';