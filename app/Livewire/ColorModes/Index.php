<?php

namespace App\Livewire\ColorModes;

use App\Models\ColorModes;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $colorModes;
    public $name;

    protected $rules = [
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:1',
    ];

    public function render()
    {
        $this->colorModes = ColorModes::get();
        return view('livewire.color-modes', ['colorModes' => $this->colorModes])
            ->layout('layouts.app');
    }
}
