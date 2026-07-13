<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('image-region-selector')
        ->assertStatus(200);
});
