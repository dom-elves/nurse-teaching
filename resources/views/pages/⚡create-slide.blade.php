<?php

use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Image;
use App\Models\Question;
use App\Models\Option;
use App\Models\Slide;

new class extends Component
{
    public Collection $questions;
    public Collection $images;
    public Collection $options;

    public array $slide = [
        'question_id' => null,
        'image_id' => null,
    ];

    public function mount(): void
    {
        $this->questions = Question::all();
        $this->images = Image::all();
        $this->options = Option::all();
    }

    public function create()
    {
        $this->validate(
            [
                'slide.question_id' => 'required|exists:questions,id',
                'slide.image_id' => 'required|exists:images,id',
            ],
            [
                'slide.question_id.required' => 'Please select a question.',
                'slide.question_id.exists' => 'The selected question is invalid.',

                'slide.image_id.required' => 'Please select an image.',
                'slide.image_id.exists' => 'The selected image is invalid.',
            ]
        );
    }
};
?>
{{--
    as this is a full page component, livewire automatically extends the layout
    app.blade has the component that determines the layout,
    which in this case is sidebar
--}}
<div>
    <h1 class="font-medium">Create a slide</h1>
    <form method="POST" wire:submit="create" class="flex flex-col space-y-6 mb-12">
        {{-- question selection --}}
        <flux:select wire:model="slide.question_id">
            <flux:select.option
                value=""
            >
                {{ __('Select a question') }}
            </flux:select.option>
                @foreach ($this->questions as $question)
                    <flux:select.option
                        value="{{ $question->id }}"
                    >
                        {{ $question->text }}
                    </flux:select.option>
                @endforeach
        </flux:select>
        @error('slide.question_id')
            <p class="text-sm text-red-500">{{ $message }}</p>
        @enderror

        {{-- image selection --}}


        {{-- option selection --}}


        <flux:button variant="primary" type="submit">
            {{ __('Save') }}
        </flux:button>
    </form>
</div>