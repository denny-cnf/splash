<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Machine extends Model
{
    protected $fillable = [
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function machineConsumables(): HasMany
    {
        return $this->hasMany(MachineConsumable::class);
    }

    public function consumables(): BelongsToMany
    {
        return $this->belongsToMany(
            Consumable::class,
            'machine_consumables'
        )->withPivot([
            'resource',
            'price',
//            'applies_to',
//            'multiplier',
        ]);
    }

    public function costPerClick(string $mode): float
    {
        $mode = strtolower($mode);
        if (!in_array($mode, ['bw', 'color'], true)) {
            throw new \InvalidArgumentException("Mode must be 'bw' or 'color'");
        }

        return $this->machineConsumables()
            ->with('consumable:id,applies_to')
            ->get()
            ->filter(fn($row) => in_array($row->consumable->applies_to, [$mode, 'all'], true))
            ->sum(function ($row) {
                if ((int)$row->resource === 0) return 0;
                return ($row->price / $row->resource) * ($row->multiplier ?? 1);
            });
    }
}
