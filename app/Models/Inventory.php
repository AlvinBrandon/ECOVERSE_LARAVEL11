<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Inventory extends Model
{
    protected $fillable = ['product_id', 'batch_id', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
