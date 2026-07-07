<?php

use Livewire\Component;
use App\Models\Image;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

new class extends Component
{
    use WithFileUploads;

    #[Validate('image|required|mimes:jpeg,png,jpg,svg|max:2048')]
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
    <form method="POST" wire:submit="createImage" class="flex flex-col space-y-6 mb-12">
        <flux:field>
            <flux:label>Image</flux:label>
            <flux:description>Upload an image to be used in slide creation.</flux:description>
            <div class="flex flex-row items-center">
                <flux:input
                    wire:model="image"
                    type="file"
                    id="upload-image"
                    name="image"
                    accept="image/png, image/jpeg, image/jpg, image/svg+xml"
                    required
                />
                <p wire:loading wire:target="image" class="text-sm text-zinc-500 dark:text-white/60">
                    Uploading...
                </p>
            </div>
        </flux:field>
        <flux:button variant="primary" type="submit">
            {{ __('Upload Image') }}
        </flux:button>
    </form>
</div>