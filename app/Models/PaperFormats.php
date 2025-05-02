<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaperFormats extends Model
{
    protected $fillable = [
        'name',
        'width',
        'height',
    ];

}
