<?php

use App\Models\User;
use App\Models\Question;
use App\Models\Image;
use App\Models\Option;

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

it('errors if nothing in slide creation is selected', function () {
    Livewire::test('pages::create-slide')
        ->set('questionId', null)
        ->set('imageId', null)
        ->set('optionIds', [])
        ->call('create')
        ->assertHasErrors('questionId')
        ->assertHasErrors('imageId')
        ->assertHasErrors('optionIds');
});

it('can save a slide under the correct conditions', function () {
    $question = Question::factory()->create();
    // don't to bother faking an actual image as in reality, it will site on the server
    // and just reference the path
    $image = Image::factory()->create();
    $options = Option::factory()
        ->count(4)
        ->sequence(
            ['label' => 'right answer'],
            ['label' => 'wrong answer 1'],
            ['label' => 'wrong answer 2'],
            ['label' => 'wrong answer 3'],
        )
        ->create();

    Livewire::test('pages::create-slide')
        ->set('questionId', $question->id)
        ->set('imageId', $image->id)
        ->set('optionIds', $options->pluck('id')->toArray())
        ->call('create')
        ->assertHasNoErrors('questionId')
        ->assertHasNoErrors('imageId')
        ->assertHasNoErrors('optionIds')
        ->assertOk();
});



