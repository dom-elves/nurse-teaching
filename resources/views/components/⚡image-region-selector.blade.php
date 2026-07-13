<?php

use Livewire\Component;
use Livewire\Attributes\Reactive;
use App\Models\Image;

new class extends Component
{
    #[Reactive]
    public ?Image $image = null;

    #[Reactive]
    public $activeOptionId = null;

    // for holding drawn region coords
    public array $polygon = [];

    public function updatedImage(string $value)
    {
        $this->polygon = [];
    }
};
?>

<div>
    @if ($image)
        <div 
            class="w-full border-2 border-purple-500 h-[682px] relative inline-block"

            >
            <img
                id="{{ $this->image->id }}"
                src="{{ route('media', $this->image->path) }}" 
                alt="{{ $this->image->title }}"
                class="w-full h-full object-contain"
            >
        </div>
    @endif
</div>