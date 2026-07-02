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

    #[Validate('required|string|max:255')]
    public string $question = '';

    #[Validate('image|required|image|mimes:jpeg,png,jpg,svg|max:2048')]
    public $image;

    #[Validate('required|string|max:255')]
    public string $option = '';

    public function mount(): void
    {

    }

    /**
     * Create a new question.
     */
    public function createQuestion()
    {
        Question::create([
            'text' => $this->question,
        ]);

        Flux::toast(variant: 'success', text: __('Question created successfully.'));
    
        $this->question = '';
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

    /**
     * Create a new Option.
     */
    public function createOption()
    {
        Option::create([
            'label' => $this->option,
        ]);

        Flux::toast(variant: 'success', text: __('Option created successfully.'));
    
        $this->option = '';
    }
};
?>

<div>
    <h1 class="font-medium mb-2">Add slide properties</h1>
    <div class="flex flex-col gap-6">
        <form method="POST" wire:submit="createQuestion" class="flex flex-col space-y-6 mb-12">
            <flux:field>
                <flux:label>Question</flux:label>
                <flux:description>Add a question to be used in slide creation.</flux:description>
                <flux:input 
                    wire:model="question"
                    type="text"
                    required 
                />
            </flux:field>
            <flux:button variant="primary" type="submit" class=>
                {{ __('Add Question') }}
            </flux:button>
        </form>

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

        <form method="POST" wire:submit="createOption" class="flex flex-col space-y-6 mb-12">
            <flux:field>
                <flux:label>Option</flux:label>
                <flux:description>Add an option to be used in slide creation.</flux:description>
                <flux:input 
                    wire:model="option"
                    type="text"
                    required 
                />
            </flux:field>
            <flux:button variant="primary" type="submit">
                {{ __('Add Option') }}
            </flux:button>
        </form>
    </div>
    {{-- @foreach ($this->options as $option)
    {{ $option->label }}
    @endforeach --}}
</div>