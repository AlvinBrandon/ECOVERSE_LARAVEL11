<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_name',
        'business_type',
        'business_address',
        'contact_email',
        'contact_phone',
        'description',
        'status'
    ];

    /**
     * Get the user that owns the application
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the documents for the application
     */
    public function documents()
    {
        return $this->hasMany(VendorDocument::class);
    }
} 