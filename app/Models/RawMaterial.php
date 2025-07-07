<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RawMaterial extends Model
{
    protected $fillable = [
        'name',
        'type',
        'unit',
        'quantity',
        'reorder_level',
        'description',
    ];

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }
}
