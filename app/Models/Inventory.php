<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Location;
use App\Models\RawMaterial;

class Inventory extends Model
{
    protected $fillable = [
        'product_id', 
        'raw_material_id', 
        'batch_id', 
        'quantity',
        'owner_id',
        'owner_type',
        'retail_markup'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
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
