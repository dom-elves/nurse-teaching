<?php

use Livewire\Livewire;
use App\Models\User;

it('renders successfully', function () {
    Livewire::test('option.create')
        ->assertStatus(200);
});

it('appears on the page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get('/upload-properties')
        ->assertSeeLivewire('option.create');
});

it('can create a new option', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test('option.create')
        ->set('option', 'Head')
        ->call('create')
        ->assertHasNoErrors();
});
