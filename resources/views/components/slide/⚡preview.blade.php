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
            <div class="w-full border-2 border-purple-500 h-[682px]">
                @if($this->image)
                    <img
                        id="{{ $this->image->id }}"
                        src="{{ route('media', $this->image->path) }}" 
                        alt="{{ $this->image->title }}"
                        class="w-full h-full object-contain"
                    >
                @endif
            </div>
            {{-- options --}}
            <div class="flex w-full border-2 border-sky-500 absolute bottom-0 right-0 left-0" style="height:150px;">
                @if($this->options)
                    @foreach($this->options as $option)
                        <div class="p-2 border-2 border-black text-center">{{ $option->label }}</div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>