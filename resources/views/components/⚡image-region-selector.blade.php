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
        <div class="w-full h-682px">
            <div class="relative inline-block border-2 border-purple-500">
                <img
                    id="{{ $this->image->id }}"
                    src="{{ route('media', $this->image->path) }}"
                    alt="{{ $this->image->title }}"
                    class="max-h-[682px] w-auto object-contain"
                >
                <canvas
                    id="image-canvas"
                    class="absolute bottom-0 left-0 right-0 bg-red-100 opacity-25 w-full h-full"
                ></canvas>
            </div>
        </div>
    @endif
</div>
<script>

function drawRegion() {
    return {
        drawing: false,
        points: [],
        ctx: null,
    }
}
</script>