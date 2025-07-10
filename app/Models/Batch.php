<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = [
        'product_id',
        'batch_id',
        'quantity',
        'expiry_date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
