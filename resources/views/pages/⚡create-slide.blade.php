<?php

use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Image;
use App\Models\Question;
use App\Models\Option;
use App\Models\Slide;
use App\Models\SlideOption;
use Livewire\Attributes\On;
use Livewire\Attributes\Computed;

new class extends Component
{
    // collections determined in mount method
    public Collection $questions;
    public Collection $images;
    public Collection $options;

    public function mount(): void
    {
        // todo: paginate, especially images
        $this->questions = Question::all();
        $this->images = Image::all();
        $this->options = Option::all();
    }

    // these are set by the user
    public ?int $questionId = null;
    public ?int $imageId = null;
    public ?array $optionIds = [];
    public ?int $correctOptionId = null;

    // computed properties for the above
    // first two need to coalesce as null to prevent render error
    #[Computed]
    public function selectedQuestion(): Question|null
    {
        return Question::find($this->questionId) ?? null;
    }

    #[Computed]
    public function selectedImage(): Image|null
    {
        return Image::find($this->imageId) ?? null;
    }

    #[Computed]
    public function selectedOptions(): Collection
    {
        return Option::whereIn('id', $this->optionIds)->get();
    }

    // listener for child component selecting which option is classed as correct
    #[On('correct-option-selected')]
    public function setCorrectOption($id)
    {
        $this->correctOptionId = $this->selectedOptions->find($id)->id;
    }

    // slide creation
    public function create()
    {
        $this->validate(
            [
                'questionId' => 'required|exists:questions,id',
                'imageId' => 'required|exists:images,id',
                'optionIds' => 'required|array|min:2|max:4',
                'optionIds.*' => 'exists:options,id',
            ],
            [
                'questionId.required' => 'Please select a question.',
                'questionId.exists' => 'The selected question is invalid.',

                'imageId.required' => 'Please select an image.',
                'imageId.exists' => 'The selected image is invalid.',

                'optionIds.required' => 'Please select two to four options.',
                'optionIds.min' => 'Please select at least two options.',
                'optionIds.max' => 'Please select no more than four options.',
            ],
        );

        $slide = Slide::create([
            'question_id' => $this->questionId,
            'image_id' => $this->imageId,
        ]);

        foreach ($this->optionIds as $optionId) {
            SlideOption::create([
                'slide_id' => $slide->id,
                'option_id' => $optionId,
                'is_correct' => $optionId == $this->correctOptionId ? true : false,
            ]);
        };

        Flux::toast(variant: 'success', text: __('Slide Created.'));
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
    <div class="flex flex-row">
        <form method="POST" wire:submit="create" class="flex flex-col space-y-6 my-12 w-1/2">

            {{-- question selection --}}
            <div>
                <h2>Question</h2>
                <flux:select wire:model.live="questionId">
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
                @error('questionId')
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
                                x-on:click="$wire.set('imageId', {{ $image->id }}); selected = {{ $image->id }}"
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
                </div>
                @error('imageId')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- option selection, again flux multiselect isn't free so i made one --}}
            {{-- todo: move this into a parent div and let alpine do all the preview stuff --}}
            <div x-data="{
                options: @js($this->options),
                addOption(event) {
                    const value = event.target.value;
                    if (value && !$wire.optionIds.includes(value)) {
                        this.$wire.optionIds.push(value);
                        $wire.$refresh();
                    }
                },
                removeOption(index) {
                    $wire.optionIds = $wire.optionIds.filter(item => item !== index);
                    $wire.$refresh();
                },
            }"
            >
                <h2>Options</h2>
                <flux:select 
                    x-on:change="addOption($event)"
                    x-bind:disabled="$wire.optionIds.length >= 4"
                >
                    <flux:select.option
                        value=""
                        disabled
                        selected
                    >
                        {{ __('Select options (up to four)') }}
                    </flux:select.option>   
                    @foreach ($this->options as $option)
                        <flux:select.option
                            value="{{ $option->id }}"
                        >
                            {{ $option->label }}
                        </flux:select.option>
                    @endforeach
                </flux:select>
                <div>
                    <template x-for="item in $wire.optionIds" :key="item">
                        <div class="flex flex-row">
                            <p x-text="item" class="my-3"></p>
                            <span x-on:click="removeOption(item)">x</span>
                        </div>
                    </template>
                </div>  
            </div>
            @error('optionIds')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror
            <flux:button variant="primary" type="submit">
                {{ __('Save') }}
            </flux:button>
        </form>

        <livewire:slide.preview
            :question="$this->selectedQuestion"
            :image="$this->selectedImage"
            :options="$this->selectedOptions"
        />
    </div>
</div>