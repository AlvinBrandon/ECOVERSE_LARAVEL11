<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'price',
        'wholesale_price',
        'retail_price',
        'customer_price',
        'stock',
        'image',
    ];

    /**
     * Get the price for the current user based on their role.
     */
    public function getPriceForUser($user = null)
    {
        $user = $user ?: Auth::user();
        if (!$user) return $this->price;
        switch ($user->role) {
            case 'wholesaler':
                return $this->wholesale_price ?? $this->price;
            case 'retailer':
                return $this->retail_price ?? $this->price;
            case 'customer':
                return $this->customer_price ?? $this->price;
            default:
                return $this->price;
        }
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'product_id');
    }
    
    public function batches()
    {
        return $this->hasMany(Batch::class);
    }
}