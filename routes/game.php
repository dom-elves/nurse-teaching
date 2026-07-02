<?php

use Illuminate\Support\Facades\Route;
use App\Models\Image;
use App\Models\Question;
use App\Models\Option;

Route::middleware(['auth', 'verified'])->group(function () {
        Route::livewire('play', 'pages::play')->name('play');
});

Route::middleware(['auth', 'verified'])->group(function () {
        Route::livewire('create-slide', 'pages::create-slide')->name('slide.create');
});

Route::middleware(['auth', 'verified'])->group(function () {
        Route::livewire('upload-properties', 'pages::upload-properties')->name('upload-properties');
});

require __DIR__.'/settings.php';