<?php

use App\Models\User;

it('page loads with correct components as an authenticated user', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get(route('slide.create'))
        ->assertOk()
        ->assertSeeLivewire('slide.preview');
});

it('unauthorised request does not allow page load', function () {
    $response = $this->get(route('slide.create'));
    $response->assertRedirect(route('login'));
});