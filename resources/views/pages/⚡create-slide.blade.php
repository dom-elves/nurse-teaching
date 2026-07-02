<?php

use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Image;

new class extends Component
{
    public Collection $images;

    public function mount(): void
    {
        $this->images = Image::all();
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
    @foreach ($this->images as $image)
        <p>{{ $image->title }}</p>
        <img
            src="{{ route('media', $image->path) }}" 
            alt="{{ $image->title }}"
            style="max-height: 200px;border:1px solid black"
        >
    @endforeach
</div>