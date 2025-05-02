<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrintProducts extends Model
{
    protected $fillable = [
        'title',
        'price',
    ];

    public function paperFormats()
    {
        return $this->belongsTo(PaperFormats::class);
    }

}
