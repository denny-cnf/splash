<?php

namespace App\Livewire\PrintProducts;

use App\Models\ColorModes;
use App\Models\PaperFormats;
use App\Models\PaperType;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $paperType = PaperType::get();
        $paperFormat = PaperFormats::get();
        $colorModes = ColorModes::get();
        return view('livewire.print-products.index', ['paperType' => $paperType, 'paperFormat' => $paperFormat, 'colorModes' => $colorModes]);
    }
}
