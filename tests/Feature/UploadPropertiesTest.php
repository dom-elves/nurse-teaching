<?php

use App\Models\User;

it('page loads with correct components as an authenticated user', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get(route('upload-properties'))
        ->assertOk()
        ->assertSeeLivewire('question.create')
        ->assertSeeLivewire('image.create')
        ->assertSeeLivewire('option.create');
});

it('unauthorised request does not allow page load', function () {
    $response = $this->get(route('upload-properties'));
    $response->assertRedirect(route('login'));
});