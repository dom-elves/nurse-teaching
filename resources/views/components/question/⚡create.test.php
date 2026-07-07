<?php

use Livewire\Livewire;
use App\Models\User;

it('renders successfully', function () {
    Livewire::test('question.create')
        ->assertStatus(200);
});

it('appears on the page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get('/upload-properties')
        ->assertSeeLivewire('question.create');
});

it('can create a new question', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test('question.create')
        ->set('question', 'Click on the head of the person')
        ->call('create')
        ->assertHasNoErrors();
});
