<?php

namespace App\Livewire\PaperFormats;

use App\Models\PaperFormats;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $formats;
    public $name;

    protected $rules = [
        'name' => 'required|string|max:255',
        'width' => 'required|numeric|min:1',
        'height' => 'required|numeric|min:1',
    ];

    public function render()
    {
        $this->formats = PaperFormats::get();
        return view('livewire.paper-formats', ['formats' => $this->formats])
            ->layout('layouts.app');
    }
}
