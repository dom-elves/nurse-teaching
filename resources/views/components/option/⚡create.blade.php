<?php

use Livewire\Component;
use App\Models\Option;
use Livewire\Attributes\Validate;

new class extends Component
{
    #[Validate('required|string|max:255')]
    public string $option = '';

    /**
     * Create a new Option.
     */
    public function createOption()
    {
        Option::create([
            'label' => $this->option,
        ]);

        $this->option = '';

        Flux::toast(variant: 'success', text: __('Option created successfully.'));
    }
};
?>

<div>
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