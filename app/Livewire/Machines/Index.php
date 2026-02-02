<?php

namespace App\Livewire\Machines;

use App\Models\ColorModes;
use App\Models\Machine;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $machine;
    public $name;

    protected $rules = [
        'name' => 'required|string|max:255',
        'is_active' => 'required|numeric|min:1',
    ];

    public function render()
    {
        $this->machine = Machine::get();
        return view('livewire.machines', ['machine' => $this->machine])
            ->layout('layouts.app');
    }
}
