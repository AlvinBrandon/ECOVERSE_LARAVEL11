<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EcoPointRedemption extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reward_id',
        'points_used',
        'voucher_code',
        'status',
        'expires_at',
        'used_at',
        'order_id'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($redemption) {
            if (!$redemption->voucher_code) {
                $redemption->voucher_code = 'ECO-' . strtoupper(Str::random(8));
            }
            
            if (!$redemption->expires_at) {
                $redemption->expires_at = now()->addMonths(6); // Default 6 months expiry
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reward()
    {
        return $this->belongsTo(EcoReward::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Check if redemption is expired
     */
    public function isExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Check if redemption is usable
     */
    public function isUsable()
    {
        return $this->status === 'active' && !$this->isExpired();
    }

    /**
     * Mark redemption as used
     */
    public function markAsUsed($orderId = null)
    {
        $this->update([
            'status' => 'used',
            'used_at' => now(),
            'order_id' => $orderId
        ]);
    }
}
