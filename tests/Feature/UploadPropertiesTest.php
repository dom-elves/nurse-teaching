<?php

use App\Models\User;

it('page loads with correct components', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get('/upload-properties')
        ->assertSeeLivewire('question.create')
        ->assertSeeLivewire('image.create')
        ->assertSeeLivewire('option.create');
});