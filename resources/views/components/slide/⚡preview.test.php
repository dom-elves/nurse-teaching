<?php

use Livewire\Livewire;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Option;
use App\Models\User;

it('renders successfully', function () {
    Livewire::test('slide.preview')
        ->assertStatus(200);
});

it('can emit the event for an option being selected as correct', function() {
    $user = User::factory()->create();

    $options = Option::factory()
        ->count(4)
        ->sequence(
            ['label' => 'right answer'],
            ['label' => 'wrong answer 1'],
            ['label' => 'wrong answer 2'],
            ['label' => 'wrong answer 3'],
        )
        ->create();

    Livewire::actingAs($user)
        ->test('slide.preview')
        ->call('selectCorrectOption', $options[0]->id)
        ->assertDispatched('correct-option-selected', id: $options[0]->id);
});
