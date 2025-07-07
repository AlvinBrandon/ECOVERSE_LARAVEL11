<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Location;
use App\Models\RawMaterial;

class Inventory extends Model
{
    protected $fillable = ['product_id', 'raw_material_id', 'batch_id', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class);
    }
}
