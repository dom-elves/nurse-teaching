<?php

use Illuminate\Support\Facades\Route;
use App\Models\Image;
use App\Models\Question;
use App\Models\Option;

Route::middleware(['auth', 'verified'])->group(function () {
        // $image = Image::first();

        // dd($image->question);
        Route::livewire('play', 'pages::play')->name('play');
});

require __DIR__.'/settings.php';