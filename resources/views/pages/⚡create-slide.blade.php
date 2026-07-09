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

    // public array $slide = [
    //     'question_id' => null,
    //     'image_id' => null,
    //     'option_ids' => [],
    // ];

    public ?int $questionId = null;
    public ?Question $question = null;

    public ?int  $imageId = null;
    public ?Image $image = null;

    public function mount(): void
    {
        $this->questions = Question::all();
        $this->images = Image::all();
        $this->options = Option::all();
    }

    // todo: figure out if it's best to make the preview purely reactive with alpine
    // or have a 'preview' button to generate & use php code
    // maybe jsut have completely separate component for creating the preview

    public function create()
    {
        $this->validate(
            [
                'slide.question_id' => 'required|exists:questions,id',
                'slide.image_id' => 'required|exists:images,id',
                'slide.option_ids' => 'required|array|min:2|max:4',
                'slide.option_ids.*' => 'exists:options,id',
            ],
            [
                'slide.question_id.required' => 'Please select a question.',
                'slide.question_id.exists' => 'The selected question is invalid.',

                'slide.image_id.required' => 'Please select an image.',
                'slide.image_id.exists' => 'The selected image is invalid.',

                'slide.option_ids.required' => 'Please select two to four options.',
                'slide.option_ids.min' => 'Please select at least two optionsm.',
                'slide.option_ids.max' => 'Please select no more than four options.',
            ]
        );
    }
    // this works cause of livewire naming convention magic
    public function updatedQuestionId($value)
    {
        $this->question = Question::find($value);
    }

    public function updatedImageId($value)
    {
        $this->image = Image::find($value);
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
                @error('slide.image_id')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- option selection, again flux multiselect isn't free so i made one --}}
            {{-- todo: move this into a parent div and let alpine do all the preview stuff --}}
            {{-- <div x-data="{
                options: @js($this->options),
                addOption(event) {
                    const value = event.target.value;
                    if (value && !$wire.slide.option_ids.includes(value)) {
                        this.$wire.slide.option_ids.push(value);
                        $wire.$refresh();
                    }
                },
                removeOption(index) {
                    $wire.slide.option_ids = $wire.slide.option_ids.filter(item => item !== index);
                    $wire.$refresh();
                },
            }"
            >
                <h2>Options</h2>
                <flux:select 
                    x-on:change="addOption($event)"
                    x-bind:disabled="$wire.slide.option_ids.length >= 4"
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
                    <template x-for="item in $wire.slide.option_ids" :key="item">
                        <div class="flex flex-row">
                            <p x-text="item" class="my-3"></p>
                            <span x-on:click="removeOption(item)">x</span>
                        </div>
                    </template>
                </div>  
            </div>
            @error('slide.option_ids')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror --}}
            <flux:button variant="primary" type="submit">
                {{ __('Save') }}
            </flux:button>
        </form>
        {{-- slide preview --}}
        <div>
            <h2>Preview</h2>
            <p>{{ $this->question?->text }}</p>
            {{-- for some weird reason, nullsafe doesn't work here --}}
            @if($this->image)
                <img
                    id="{{ $this->image->id }}"
                    src="{{ route('media', $this->image->path) }}" 
                    alt="{{ $this->image->title }}"
                    style="max-height:200px;border:1px solid black"
                >
            @endif
            {{-- <p>{{ $this->slide['image_id'] }}</p>
            @foreach($this->slide['option_ids'] as $ids)
                {{ $ids }}
            @endforeach --}}
        </div>
    </div>
</div>