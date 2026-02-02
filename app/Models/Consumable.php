<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Consumable extends Model
{
    protected $fillable = [
        'name',
        'code',
    ];

    public function machineConsumables(): HasMany
    {
        return $this->hasMany(MachineConsumable::class);
    }

    public function machines(): BelongsToMany
    {
        return $this->belongsToMany(
            Machine::class,
            'machine_consumables'
        )->withPivot([
            'resource',
            'price',
//            'multiplier',
        ]);
    }
}
