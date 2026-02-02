<?php

namespace App\Livewire\Consumables;

use App\Models\Consumable;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $consumables;
    public $name;

    protected $rules = [
        'name' => 'required|string|max:255',
        'is_active' => 'required|numeric|min:1',
    ];

    public function render()
    {
        $this->consumables = Consumable::get();
        return view('livewire.consumables', ['consumables' => $this->consumables])
            ->layout('layouts.app');
    }
}
