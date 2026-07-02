<?php

use Livewire\Component;
use App\Models\Question;
use Livewire\Attributes\Validate;

new class extends Component
{
    #[Validate('required|string|max:255')]
    public string $question = '';

    /**
     * Create a new question.
     */
    public function create()
    {
        Question::create([
            'text' => $this->question,
        ]);

        $this->question = '';

        Flux::toast(variant: 'success', text: __('Question created successfully.'));
    }
};
?>

<div>
    <form method="POST" wire:submit="create" class="flex flex-col space-y-6 mb-12">
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
</div>