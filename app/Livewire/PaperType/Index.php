<?php

namespace App\Livewire\PaperType;

use App\Models\PaperFormats;
use App\Models\PaperType;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $paperType;
    public $name;

    protected $rules = [
        'name' => 'required|string|max:255',
        'width' => 'required|numeric|min:1',
        'height' => 'required|numeric|min:1',
    ];

    public function render()
    {
        $this->paperType = PaperType::get();
        return view('livewire.paper-types', ['paperType' => $this->paperType])
            ->layout('layouts.app');
    }
}
