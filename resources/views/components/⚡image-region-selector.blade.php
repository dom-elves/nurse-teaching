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

    #[Reactive]
    public $existingRegions = [];

    public $polygon = [];

    public function updatedImage($value)
    {
        $this->polygon = [];
    }
};
?>

<div>
    @if ($image)
        <div class="w-full h-[682px]">
            <div
                class="relative inline-block border-2 border-purple-500"
                x-data="drawRegion()"
                wire:ignore.self
            >
                <img
                    x-ref="image"
                    id="{{ $this->image->id }}"
                    src="{{ route('media', $this->image->path) }}"
                    alt="{{ $this->image->title }}"
                    class="max-h-[682px] w-auto object-contain"
                    style="touch-action: none;"
                    @load="sizeCanvas()"
                    @mousedown="start($event)"
                    @mousemove="move($event)"
                    @mouseup="end()"
                    @mouseleave="end()"
                    @touchstart="start($event)"
                    @touchmove="move($event)"
                    @touchend="end()"
                >
                <canvas
                    x-ref="canvas"
                    class="absolute top-0 left-0 opacity-25 cursor-crosshair bg-red-100"
                ></canvas>
            </div>
        </div>
    @endif
</div>

{{-- @script is so the livewire component instance calls script tags on component render --}}
@script
<script>
    // Alpine.data registers the component in alpine's interal registry, so it can be called on remount
    Alpine.data('drawRegion', () => ({
        drawing: false,
        points: [],
        ctx: null,

        // runs when component is initialised
        // calls sizeCanvas() within it so the canvas is set before component initalises
        init() {
            this.ctx = this.$refs.canvas.getContext('2d');
            if (this.$refs.image.complete) {
                this.sizeCanvas();
            };
        },

        // set canvas width & height to match the image
        // important later for region selection
        sizeCanvas() {
            this.$refs.canvas.width = this.$refs.image.clientWidth;
            this.$refs.canvas.height = this.$refs.image.clientHeight;
            this.redraw();
        },

        redraw() {
            const ctx = this.ctx;
            const canvas = this.$refs.canvas;
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // add stuff for existing points later
        },
    }));
</script>
@endscript