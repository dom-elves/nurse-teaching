<?php

use Illuminate\Support\Facades\Route;
use App\Models\Slide;
use App\Models\Question;
use App\Models\Option;

Route::middleware(['auth', 'verified'])->group(function () {
        $q = Question::first();

        dd($q->slide);
        Route::livewire('play', 'pages::play')->name('play');
});

require __DIR__.'/settings.php';