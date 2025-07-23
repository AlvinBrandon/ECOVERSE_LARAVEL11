<?php

namespace App\Services;

use App\Models\User;
use App\Models\EcoPointTransaction;
use App\Models\EcoReward;
use App\Models\EcoPointRedemption;
use App\Models\Order;

class EcoPointService
{
    /**
     * Award eco points to a user
     */
    public function awardPoints(User $user, int $points, string $source, string $description, array $metadata = [])
    {
        // Create transaction record
        EcoPointTransaction::create([
            'user_id' => $user->id,
            'type' => 'earned',
            'points' => $points,
            'source' => $source,
            'description' => $description,
            'metadata' => $metadata
        ]);

        // Update user's total eco points
        $user->increment('eco_points', $points);

        return $user;
    }

    /**
     * Deduct eco points from a user (for redemptions)
     */
    public function deductPoints(User $user, int $points, string $source, string $description, array $metadata = [])
    {
        if ($user->eco_points < $points) {
            throw new \Exception('Insufficient eco points. User has ' . $user->eco_points . ' points but trying to deduct ' . $points);
        }

        // Create transaction record
        EcoPointTransaction::create([
            'user_id' => $user->id,
            'type' => 'redeemed',
            'points' => -$points,
            'source' => $source,
            'description' => $description,
            'metadata' => $metadata
        ]);

        // Update user's total eco points
        $user->decrement('eco_points', $points);

        return $user;
    }

    /**
     * Award points for order completion
     */
    public function awardOrderPoints(Order $order)
    {
        $user = $order->user;
        
        // Calculate points based on order value (1 point per $1, minimum 10 points)
        $basePoints = max(10, floor($order->total_price));
        
        // Bonus points for eco-friendly products (you can customize this logic)
        $bonusPoints = 0;
        if ($order->product && $this->isEcoFriendlyProduct($order->product)) {
            $bonusPoints = floor($basePoints * 0.5); // 50% bonus for eco products
        }
        
        $totalPoints = $basePoints + $bonusPoints;
        
        $description = "Eco points earned for order #{$order->id}";
        if ($bonusPoints > 0) {
            $description .= " (includes {$bonusPoints} eco-friendly bonus points)";
        }

        return $this->awardPoints(
            $user,
            $totalPoints,
            'order',
            $description,
            [
                'order_id' => $order->id,
                'base_points' => $basePoints,
                'bonus_points' => $bonusPoints,
                'order_value' => $order->total_price
            ]
        );
    }

    /**
     * Award points for profile completion
     */
    public function awardProfileCompletionPoints(User $user)
    {
        // Check if user has already received profile completion points
        $existingTransaction = EcoPointTransaction::where('user_id', $user->id)
            ->where('source', 'profile_completion')
            ->first();

        if ($existingTransaction) {
            return $user; // Already awarded
        }

        return $this->awardPoints(
            $user,
            25,
            'profile_completion',
            'Profile completion bonus points',
            ['completion_date' => now()]
        );
    }

    /**
     * Award points for referrals
     */
    public function awardReferralPoints(User $referrer, User $referred)
    {
        return $this->awardPoints(
            $referrer,
            50,
            'referral',
            "Referral bonus for inviting {$referred->name}",
            ['referred_user_id' => $referred->id]
        );
    }

    /**
     * Award points for product reviews
     */
    public function awardReviewPoints(User $user, $productId)
    {
        return $this->awardPoints(
            $user,
            5,
            'review',
            'Product review points',
            ['product_id' => $productId]
        );
    }

    /**
     * Get user's eco point balance
     */
    public function getUserBalance(User $user)
    {
        return $user->eco_points;
    }

    /**
     * Get user's redeemable points (points that can be used for rewards)
     */
    public function getRedeemablePoints(User $user)
    {
        $minimumRedemptionThreshold = 100; // Minimum points needed to start redeeming
        
        if ($user->eco_points < $minimumRedemptionThreshold) {
            return 0;
        }
        
        return $user->eco_points;
    }

    /**
     * Get available rewards for user based on their points
     */
    public function getAvailableRewards(User $user)
    {
        return EcoReward::where('is_active', true)
            ->where('points_required', '<=', $user->eco_points)
            ->where(function($query) {
                $query->where('stock', -1) // Unlimited stock
                      ->orWhereRaw('stock > (SELECT COUNT(*) FROM eco_point_redemptions WHERE reward_id = eco_rewards.id AND status != "expired")');
            })
            ->orderBy('points_required', 'asc')
            ->get();
    }

    /**
     * Redeem points for a reward
     */
    public function redeemReward(User $user, EcoReward $reward)
    {
        // Check if user has enough points
        if ($user->eco_points < $reward->points_required) {
            throw new \Exception("Insufficient points. You have {$user->eco_points} points but need {$reward->points_required}");
        }

        // Check if reward is available
        if (!$reward->isAvailable()) {
            throw new \Exception("This reward is no longer available");
        }

        // Deduct points
        $this->deductPoints(
            $user,
            $reward->points_required,
            'redemption',
            "Redeemed: {$reward->name}",
            ['reward_id' => $reward->id]
        );

        // Create redemption record
        $redemption = EcoPointRedemption::create([
            'user_id' => $user->id,
            'reward_id' => $reward->id,
            'points_used' => $reward->points_required,
        ]);

        return $redemption;
    }

    /**
     * Get user's active vouchers/redemptions
     */
    public function getUserActiveRedemptions(User $user)
    {
        return EcoPointRedemption::where('user_id', $user->id)
            ->where('status', 'active')
            ->where(function($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>', now());
            })
            ->with('reward')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get user's eco point transaction history
     */
    public function getUserTransactions(User $user, int $limit = 10)
    {
        return EcoPointTransaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Check if a product is eco-friendly (customize this logic based on your product attributes)
     */
    private function isEcoFriendlyProduct($product)
    {
        // This is a placeholder - you can customize based on your product attributes
        // For example, check if product has eco-friendly tags, categories, or attributes
        
        if (!$product) {
            return false;
        }

        // Example logic - you can modify this based on your product structure
        $ecoKeywords = ['eco', 'organic', 'sustainable', 'biodegradable', 'renewable', 'recycled'];
        
        $productName = strtolower($product->name ?? '');
        $productDescription = strtolower($product->description ?? '');
        
        foreach ($ecoKeywords as $keyword) {
            if (str_contains($productName, $keyword) || str_contains($productDescription, $keyword)) {
                return true;
            }
        }
        
        return false;
    }
}
