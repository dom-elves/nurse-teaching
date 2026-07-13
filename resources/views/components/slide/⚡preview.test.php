<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('slide.preview')
        ->assertStatus(200);
});
