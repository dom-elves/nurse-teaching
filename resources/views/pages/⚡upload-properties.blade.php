<?php

use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Question;
use App\Models\Image;
use App\Models\Option;
use Illuminate\Support\Facades\Storage;
use Native\Mobile\Facades\Camera;
use Native\Mobile\Attributes\OnNative;
use Native\Mobile\Events\Gallery\MediaSelected;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

new class extends Component
{
    use WithFileUploads;

    #[Validate('image|required|image|mimes:jpeg,png,jpg,svg|max:2048')]
    public $image;

    public function mount(): void
    {

    }

    /**
     * Create (upload) a new image.
     */
    public function createImage()
    {
        $path = $this->image->store('images', 'public');

        Image::create([
            'title' => $this->image->getClientOriginalName(),
            'path' => $path,
        ]);

        Flux::toast(variant: 'success', text: __('Image uploaded successfully.'));

        $this->image = null;
    }
};
?>

<div>
    <h1 class="font-medium mb-2">Add slide properties</h1>
    <div class="flex flex-col gap-6">
        <livewire:question.create />

        {{-- <flux:button variant="primary" wire:click="createImage" class="mb-12">
            {{ __('Choose Images') }}
        </flux:button> --}}

        <form method="POST" wire:submit="createImage" class="flex flex-col space-y-6 mb-12">
            <flux:field>
                <flux:label>Image</flux:label>
                <flux:description>Upload an image to be used in slide creation.</flux:description>
                <flux:input
                    wire:model="image"
                    type="file"
                    id="upload-image"
                    name="image"
                    accept="image/png, image/jpeg, image/jpg, image/svg+xml"
                    required
                />
            </flux:field>
            <flux:button variant="primary" type="submit">
                {{ __('Upload Image') }}
            </flux:button>
        </form>

        <livewire:option.create />
    </div>
    {{-- @foreach ($this->options as $option)
    {{ $option->label }}
    @endforeach --}}
</div>