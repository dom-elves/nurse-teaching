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

    public $activeOptionId = null;

    public function updatedActiveOptionId($id)
    {
        dump($id);
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
            <livewire:image-region-selector
                :image="$this->image"
                :active-option-id="$this->activeOptionId"
            />
            {{-- options --}}
            <div 
                x-data="{ selected: false }"
                class="flex w-full border-2 border-sky-500 absolute bottom-0 right-0 left-0" 
                style="height:150px;"
            >
                @if($options)
                    @foreach($options as $option)
                        <div
                            wire:key="option-{{ $option->id }}"
                            x-on:click="$wire.set('activeOptionId', {{ $option->id }});selected = {{ $option->id }}"
                            class="p-2 text-center flex-1"
                            :class="{'border-2 border-red-500 bg-red-50' : selected == {{ $option->id }} }"
                        >
                            {{ $option->label }}
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>