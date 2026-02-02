<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MachineConsumable extends Model
{
    protected $fillable = [
        'machine_id',
        'consumable_id',
        'resource',
        'price',
        'applies_to',
        'multiplier',
    ];

    protected $casts = [
        'resource'   => 'integer',
        'price'      => 'integer',
        'multiplier' => 'decimal:4',
    ];

    public function machine(): BelongsTo
    {
        return $this->belongsTo(Machine::class);
    }

    public function consumable(): BelongsTo
    {
        return $this->belongsTo(Consumable::class);
    }

    public function costPerClick(): float
    {
        if ($this->resource == 0) return 0;
        return ($this->price / $this->resource) * $this->multiplier;
    }
}
