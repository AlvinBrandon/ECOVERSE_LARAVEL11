<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelpRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'message',
        'status',
        'response'
    ];

    /**
     * Get the user that made the request
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 