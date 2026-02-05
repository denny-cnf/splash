<?php

namespace App\Livewire\PrintProducts;

use App\Models\ColorModes;
use App\Models\Machine;
use App\Models\PaperFormats;
use App\Models\PaperType;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $paperType = PaperType::all();
        $paperFormat = PaperFormats::get();
        $colorModes = ColorModes::get();
        $machines = Machine::query()->where('is_active', true)->with('machineConsumables.consumable')->orderBy('name')->get();
        return view('livewire.print-products.index', ['paperType' => $paperType, 'paperFormat' => $paperFormat, 'colorModes' => $colorModes, 'machines' => $machines]);
    }
}
