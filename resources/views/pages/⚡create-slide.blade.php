<?php

use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Image;
use App\Models\Question;
use App\Models\Option;

new class extends Component
{
    public Collection $questions;
    public Collection $images;
    public Collection $options;

    public function mount(): void
    {
        $this->questions = Question::all();
        $this->images = Image::all();
        $this->options = Option::all();
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