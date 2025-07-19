<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_application_id',
        'path',
        'original_name'
    ];

    /**
     * Get the vendor application that owns the document
     */
    public function application()
    {
        return $this->belongsTo(VendorApplication::class);
    }
} 