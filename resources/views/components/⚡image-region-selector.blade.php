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
                >
                <canvas
                    x-ref="canvas"
                    class="absolute top-0 left-0 opacity-25 cursor-crosshair bg-red-100"
                    @load="sizeCanvas()"
                    @mousedown="start($event)"
                    @mousemove="move($event)"
                    @mouseup="end()"
                    @mouseleave="end()"
                    @touchstart="start($event)"
                    @touchmove="move($event)"
                    @touchend="end()"
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

        /* Mapping */
        // takes canvas dimenions 'out' of viewport dimensions
        // and gets pixel co-ords from that
        getPixelPos(e) {
            const rect = this.$refs.canvas.getBoundingClientRect();
            const point = e.touches ? e.touches[0] : e;
            return { x: point.clientX - rect.left, y: point.clientY - rect.top };
        },

        // converts pixel co-ords to decimal fraction, relative to canvas
        // so 0.4 0.3 is 40% "up" and 30% "across"
        toNormalized(pixelPt) {
            const canvas = this.$refs.canvas;
            return { x: pixelPt.x / canvas.width, y: pixelPt.y / canvas.height };
        },

        // inverse of the above
        toPixels(normPt) {
            const canvas = this.$refs.canvas;
            return { x: normPt.x * canvas.width, y: normPt.y * canvas.height };
        },

        /* Drawing */
        // add first point to this.points array
        start(e) {
            this.drawing = true;
            this.points = [this.getPixelPos(e)];
            e.preventDefault();
        },

        // every move adds points
        move(e) {
            if (!this.drawing) return;
            this.points.push(this.getPixelPos(e));
            this.redraw();
            e.preventDefault();
        },

        // stop drawing
        end() {
            if (!this.drawing) return;
            this.drawing = false;
            const simplifiedPixels = this.simplify(this.points, 2);
            const normalized = simplifiedPixels.map(p => this.toNormalized(p));
            this.$wire.savePolygon(normalized);
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