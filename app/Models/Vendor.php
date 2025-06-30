<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'type',
        'ursb_document',
        'address',
        'tin',
        'status',
        'scheduled_visit',
    ];

    protected $dates = [
        'scheduled_visit',
        'created_at',
        'updated_at',
    ];
}
