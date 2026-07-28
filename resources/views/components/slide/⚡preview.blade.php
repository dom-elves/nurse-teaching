<?php

use Livewire\Component;
use Livewire\Attributes\Reactive;
use App\Models\Question;
use App\Models\Image;
use App\Models\Option;
use Illuminate\Database\Eloquent\Collection;

new class extends Component
{
    #[Reactive]
    public ?Question $question = null;

    #[Reactive]
    public ?Image $image = null;

    #[Reactive]
    public ?Collection $options = null;

    // this can be done inline with:
    // wire:click="$dispatch('correct-option-selected', { id: {{ $option->id }}})"
    // but having it like this makes it testable
    public function selectCorrectOption(int $id): void
    {
        $this->dispatch('correct-option-selected', id: $id);
    }

};
?>

<div>
    {{-- slide mobile preview --}}
    <div class="flex flex-col items-center">
        <h2>Preview</h2>
        <div class="flex flex-col items-center relative" style="height:932px;width:432px;border:1px solid black">
            {{-- question --}}
            <div class="flex w-full justify-center items-center border-2 border-indigo-500" style="height:100px">
                <p>{{ $this->question?->text }}</p>
            </div>
            {{-- image --}}
            <div class="w-full h-[682px]">
                <div class="relative inline-block border-2 border-purple-500">
                    @if ($image)
                        <img
                            id="{{ $image->id }}"
                            src="{{ route('media', $image?->path) }}"
                            alt="{{ $image->title }}"
                            class="max-h-[682px] w-auto object-contain"
                        >
                    @else
                        <div>
                            nothing to see here
                        </div>
                    @endif
                </div>
            </div>
            {{-- options --}}
            <div 
                x-data="{ selected: false }"
                class="flex w-full border-2 border-sky-500 absolute bottom-0 right-0 left-0" 
                style="height:150px;"
            >
                @foreach($options ?? [] as $option)
                    <div
                        wire:key="option-{{ $option->id }}"
                        x-on:click="selected = {{ $option->id }}"
                        wire:click="selectCorrectOption({{ $option->id }})"
                        class="p-2 text-center flex-1"
                        :class="{'border-2 border-red-500 bg-red-50' : selected == {{ $option->id }} }"
                    >
                        {{ $option->label }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>