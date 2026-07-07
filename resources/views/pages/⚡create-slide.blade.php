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
    <form method="POST" wire:submit="create" class="flex flex-col space-y-6 my-12">
        {{-- question selection --}}
        <div>
            <h2>Question</h2>
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
        </div>
        {{-- image selection, no free flux equivalent so had to make a basic one --}}
        <div>
            <h2>Image</h2>
            <div class="flex flex-wrap gap-4" x-data="{ selected: null }">
                @foreach ($this->images as $image)
                    <div class="relative flex flex-col group cursor-pointer" style="max-height:200px">
                        <img
                            id="{{ $image->id }}"
                            src="{{ route('media', $image->path) }}" 
                            alt="{{ $image->title }}"
                            style="max-height:200px;border:1px solid black"
                            :class="{ 'opacity-25': selected === {{ $image->id }} }"
                            x-on:click="$wire.set('slide.image_id', {{ $image->id }}); selected = {{ $image->id }}"
                            >
                        <p
                            :class="{ 'visible': selected === {{ $image->id }} }" 
                            class="absolute text-center bottom-0 right-0 left-0 invisible 
                                  group-hover:visible opacity-80 bg-black text-white text-sm"
                        >
                            {{ $image->title }}
                        </p>
                    </div>
                @endforeach
                {{ $this->slide['question_id']}}
                {{ $this->slide['image_id'] }}
            </div>
            @error('slide.image_id')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- option selection --}}


        <flux:button variant="primary" type="submit">
            {{ __('Save') }}
        </flux:button>
    </form>
</div>