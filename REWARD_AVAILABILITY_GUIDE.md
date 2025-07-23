# 🎁 How Rewards Become Available - Complete Guide

## ✅ **Current Status: All 6 Rewards Are Now Available!**

The issue was that rewards had `stock: -1` which made them unavailable. This has been fixed and all rewards now show proper stock levels.

---

## 🔧 **How Rewards Become Available**

### **1. Database Requirements**
For a reward to appear on `/eco-points/rewards`, it must meet these criteria:

```sql
-- Reward must be active
is_active = true  

-- AND stock must be available
(stock > 0 OR stock IS NULL)
```

### **2. Current Reward Status** ✅
| Reward | Points | Stock | Status |
|--------|--------|-------|--------|
| Free Shipping | 300 | 1,000 | ✅ Available |
| 5% Discount | 500 | 500 | ✅ Available |
| 10% Discount | 1,000 | 300 | ✅ Available |
| $10 Off Voucher | 1,500 | 200 | ✅ Available |
| 15% Eco Special | 2,000 | 150 | ✅ Available |
| $25 Premium | 3,000 | 100 | ✅ Available |

---

## 🛠️ **How to Add New Rewards**

### **Method 1: Database Seeder (Recommended)**
Create a new seeder or update existing one:

```php
// database/seeders/NewRewardSeeder.php
EcoReward::create([
    'name' => 'Free Coffee Voucher',
    'description' => 'Enjoy a free eco-friendly coffee',
    'points_required' => 150,
    'type' => 'voucher',
    'value' => '$5.00',
    'stock' => 200,
    'is_active' => true,
    'conditions' => ['Valid at participating eco-cafes', 'One use per customer']
]);
```

### **Method 2: Tinker Command**
```bash
php artisan tinker

# Create new reward
EcoReward::create([
    'name' => 'Eco Tote Bag',
    'description' => 'Sustainable canvas tote bag',
    'points_required' => 750,
    'type' => 'physical',
    'value' => '1 Bag',
    'stock' => 50,
    'is_active' => true,
    'conditions' => ['Free shipping included', 'Made from recycled materials']
]);
```

### **Method 3: Admin Interface** (Future Enhancement)
Create an admin panel to manage rewards through a web interface.

---

## 📊 **Reward Management**

### **Activate/Deactivate Rewards**
```php
// Deactivate a reward
EcoReward::where('name', 'Seasonal Discount')->update(['is_active' => false]);

// Reactivate a reward
EcoReward::where('name', 'Seasonal Discount')->update(['is_active' => true]);
```

### **Update Stock Levels**
```php
// Set specific stock
EcoReward::where('name', 'Free Shipping')->update(['stock' => 500]);

// Set unlimited stock
EcoReward::where('name', 'Digital Discount')->update(['stock' => null]);

// Deduct stock after redemption (handled automatically by EcoPointService)
```

### **Modify Reward Details**
```php
EcoReward::where('name', 'Old Name')->update([
    'name' => 'New Name',
    'points_required' => 400,
    'description' => 'Updated description',
    'value' => '$15.00'
]);
```

---

## 🎯 **Reward Types & Examples**

### **Discount Rewards** (`type: 'discount'`)
- Percentage off orders
- Fixed amount off orders
- Category-specific discounts

### **Shipping Rewards** (`type: 'shipping'`)
- Free standard shipping
- Express shipping upgrades
- Free returns

### **Voucher Rewards** (`type: 'voucher'`)
- Store credit
- Gift cards
- Partner merchant vouchers

### **Physical Rewards** (`type: 'physical'`)
- Eco-friendly products
- Branded merchandise
- Sustainable accessories

---

## 🚀 **Best Practices**

### **Stock Management**
- **Limited Items**: Set specific stock numbers (e.g., physical products)
- **Digital Items**: Use `null` stock for unlimited (e.g., discount codes)
- **Monitor Stock**: Check low-stock rewards regularly

### **Point Values**
- **Entry Level**: 100-500 points (encourage first redemption)
- **Mid Tier**: 500-1500 points (regular engagement)
- **Premium**: 1500+ points (loyalty rewards)

### **Conditions**
Always include clear terms:
```php
'conditions' => [
    'Minimum order value: $25',
    'Valid for 30 days from redemption',
    'Cannot be combined with other offers',
    'One use per customer'
]
```

---

## 📈 **Analytics & Monitoring**

### **Popular Rewards**
```php
// Most redeemed rewards
EcoPointRedemption::select('reward_id', DB::raw('count(*) as redemptions'))
    ->groupBy('reward_id')
    ->orderBy('redemptions', 'desc')
    ->with('reward')
    ->get();
```

### **Stock Alerts**
```php
// Low stock warnings
EcoReward::where('stock', '<=', 10)
    ->where('stock', '>', 0)
    ->where('is_active', true)
    ->get();
```

---

## ✅ **System is Ready!**

Your rewards are now live and available at:
- **Direct URL**: `/eco-points/rewards`
- **Profile Link**: Profile → Eco Points → Browse Rewards
- **Quick Action**: Profile → Quick Actions → Redeem Points

All 6 rewards are active and ready for redemption! 🎉
