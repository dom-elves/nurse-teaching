<?php

use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Question;
use App\Models\Image;
use App\Models\Option;

new class extends Component
{
    public string $question = '';
    public Collection $questions;

    public string $image = '';
    public Collection $images;

    public string $option = '';
    public Collection $options;

    public function mount(): void
    {
        $this->questions = Question::all();
        $this->images = Image::all();
        $this->options = Option::all();
    }

    /**
     * Create a new question.
     */
    public function createQuestion(): void
    {
        $this->validate([
            'question' => ['required', 'string', 'max:255'],
        ]);

        Question::create([
            'text' => $this->question,
        ]);

        Flux::toast(variant: 'success', text: __('Question created successfully.'));
    
        $this->question = '';
        $this->questions = Question::all();
    }

    // different logic probably for image

    /**
     * Create a new Option.
     */
    public function createOption(): void
    {
        $this->validate([
            'option' => ['required', 'string', 'max:255'],
        ]);

        Option::create([
            'label' => $this->option,
        ]);

        Flux::toast(variant: 'success', text: __('Option created successfully.'));
    
        $this->option = '';
        $this->options = Option::all();
    }
};
?>

<div>
    <h1 class="font-medium mb-2">Add slide properties</h1>
    <div class="flex flex-col gap-6">
        <form method="POST" wire:submit="createQuestion" class="flex flex-col space-y-6">
            <flux:field>
                <flux:label>Question</flux:label>
                <flux:description>Add a question to be used in slide creation.</flux:description>
                <flux:input 
                    wire:model="question"
                    type="text"
                    required 
                />
            </flux:field>
            <div class="flex items-center gap-4">
                <flux:button variant="primary" type="submit">
                    {{ __('Add Question') }}
                </flux:button>
            </div>
        </form>

        <p>upload an image</p>

        <form method="POST" wire:submit="createOption" class="flex flex-col space-y-6">
            <flux:field>
                <flux:label>Option</flux:label>
                <flux:description>Add an option to be used in slide creation.</flux:description>
                <flux:input 
                    wire:model="option"
                    type="text"
                    required 
                />
            </flux:field>
            <div class="flex items-center gap-4">
                <flux:button variant="primary" type="submit">
                    {{ __('Add Option') }}
                </flux:button>
            </div>
        </form>
    </div>
    @foreach ($this->options as $option)
    {{ $option->label }}
    @endforeach
</div>