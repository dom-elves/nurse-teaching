<?php

use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;

new class extends Component
{
    public function mount(): void
    {

    }
};
?>

<div>
    <h1 class="font-medium mb-2">Add slide properties</h1>
    <p class="text-sm mb-6">Add questions, images and options to be used in slide creation.</p>
    <div class="flex flex-col gap-6">
        <livewire:question.create />

        {{-- <flux:button variant="primary" wire:click="createImage" class="mb-12">
            {{ __('Choose Images') }}
        </flux:button> --}}

        <livewire:image.create />

        <livewire:option.create />
    </div>
    {{-- @foreach ($this->options as $option)
    {{ $option->label }}
    @endforeach --}}
</div>