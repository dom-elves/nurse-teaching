<?php

use Livewire\Livewire;
use App\Models\User;
use Illuminate\Http\UploadedFile;

it('renders successfully', function () {
    Livewire::test('image.create')
        ->assertStatus(200);
});

it('appears on the page', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get('/upload-properties')
        ->assertSeeLivewire('image.create');
});

it('can create a new image', function () {
    $user = User::factory()->create();

    $image = UploadedFile::fake()->image('human-body.jpg');

    Livewire::actingAs($user)
        ->test('image.create')
        ->set('image', $image)
        ->call('create')
        ->assertHasNoErrors();
});
