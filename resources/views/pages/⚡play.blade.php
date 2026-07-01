<?php

use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Image;

new class extends Component
{
    public Collection $images;

    public function mount()
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
    it's this one
    {{ $this->images[0]->questions[0]->options }}
</div>