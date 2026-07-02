<?php

use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Slide;

new class extends Component
{
    public Collection $slides;

    public function mount()
    {
        $this->slides = Slide::all();
    }
};
?>
{{--
    as this is a full page component, livewire automatically extends the layout
    app.blade has the component that determines the layout,
    which in this case is sidebar
--}}
<div>
    it's this one
    <p>{{ $this->slides[0] }}</p>
    <p>{{ $this->slides[0]->image->title }}</p>
    <p>{{ $this->slides[0]->question->text }}</p>
    @foreach ($this->slides[0]->slideOptions as $slideOption)
        <p>{{ $slideOption->option->label }} - {{ $slideOption->is_correct ? 'Correct' : 'Incorrect' }}</p>
    @endforeach
</div>