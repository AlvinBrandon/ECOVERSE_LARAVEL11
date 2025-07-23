<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcoReward extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'points_required',
        'type',
        'value',
        'stock',
        'is_active',
        'conditions'
    ];

    protected $casts = [
        'conditions' => 'array',
    ];

    public function redemptions()
    {
        return $this->hasMany(EcoPointRedemption::class, 'reward_id');
    }

    /**
     * Check if reward is available for redemption
     */
    public function isAvailable()
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->stock > 0 && $this->redemptions()->where('status', '!=', 'expired')->count() >= $this->stock) {
            return false;
        }

        return true;
    }

    /**
     * Get formatted value string
     */
    public function getFormattedValueAttribute()
    {
        return match($this->type) {
            'discount_percentage' => $this->value . '% Off',
            'discount_fixed' => '$' . $this->value . ' Off',
            'free_shipping' => 'Free Shipping',
            'product_voucher' => '$' . $this->value . ' Voucher',
            default => $this->value
        };
    }
}
