<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EcoPointService;
use App\Models\EcoReward;
use App\Models\EcoPointRedemption;
use Illuminate\Support\Facades\Auth;

class EcoPointController extends Controller
{
    protected $ecoPointService;

    public function __construct(EcoPointService $ecoPointService)
    {
        $this->ecoPointService = $ecoPointService;
    }

    /**
     * Show the rewards catalog page
     */
    public function rewards()
    {
        $user = Auth::user();
        $rewards = EcoReward::where('is_active', true)
            ->where(function($query) {
                $query->where('stock', '>', 0)
                      ->orWhereNull('stock'); // Allow unlimited stock (null)
            })
            ->orderBy('points_required', 'asc')
            ->get();

        return view('eco-points.rewards', compact('user', 'rewards'));
    }

    /**
     * Show user's redemption history
     */
    public function history()
    {
        $user = Auth::user();
        $redemptions = EcoPointRedemption::with('reward')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('eco-points.history', compact('user', 'redemptions'));
    }

    /**
     * Redeem a reward
     */
    public function redeem(Request $request, $rewardId)
    {
        try {
            $user = Auth::user();
            $reward = EcoReward::findOrFail($rewardId);

            // Check if user has enough points
            if ($user->eco_points < $reward->points_required) {
                return back()->with('error', 'Insufficient eco-points. You need ' . $reward->points_required . ' points but only have ' . $user->eco_points . '.');
            }

            // Check if reward is in stock (null means unlimited stock)
            if ($reward->stock !== null && $reward->stock <= 0) {
                return back()->with('error', 'This reward is currently out of stock.');
            }

            // Process redemption
            $voucher = $this->ecoPointService->redeemReward($user, $reward);

            return back()->with('success', 'Congratulations! You redeemed "' . $reward->name . '". Your voucher code is: ' . $voucher->voucher_code . '. Check your email for details.');

        } catch (\Exception $e) {
            return back()->with('error', 'Redemption failed: ' . $e->getMessage());
        }
    }

    /**
     * Show individual voucher details
     */
    public function voucher($voucherCode)
    {
        $user = Auth::user();
        $redemption = EcoPointRedemption::with('reward')
            ->where('user_id', $user->id)
            ->where('voucher_code', $voucherCode)
            ->firstOrFail();

        return view('eco-points.voucher', compact('redemption'));
    }

    /**
     * API endpoint to get user's current eco-points
     */
    public function balance()
    {
        $user = Auth::user();
        return response()->json([
            'eco_points' => $user->eco_points,
            'redeemable_points' => $user->eco_points >= 100 ? $user->eco_points : 0
        ]);
    }

    /**
     * Validate voucher code for checkout process
     */
    public function validateVoucher(Request $request)
    {
        $request->validate([
            'voucher_code' => 'required|string',
            'cart_total' => 'numeric|min:0'
        ]);

        $user = Auth::user();
        $voucherCode = $request->voucher_code;
        $cartTotal = $request->cart_total ?? 0;

        // Find the voucher redemption
        $redemption = EcoPointRedemption::with('reward')
            ->where('user_id', $user->id)
            ->where('voucher_code', $voucherCode)
            ->where('status', 'active')
            ->first();

        if (!$redemption) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid voucher code or voucher not found.'
            ]);
        }

        if ($redemption->isExpired()) {
            return response()->json([
                'success' => false,
                'message' => 'This voucher has expired.'
            ]);
        }

        if (!$redemption->isUsable()) {
            return response()->json([
                'success' => false,
                'message' => 'This voucher has already been used or is no longer active.'
            ]);
        }

        // Calculate discount based on reward type and value
        $discount = 0;
        $reward = $redemption->reward;
        
        switch($reward->type) {
            case 'discount_percentage':
                $discount = $cartTotal * ($reward->value / 100);
                break;
            case 'discount_fixed':
                $discount = min($reward->value, $cartTotal);
                break;
            case 'product_voucher':
                $discount = min($reward->value, $cartTotal);
                break;
            case 'free_shipping':
                $discount = 5000; // Assume shipping cost of UGX 5,000
                break;
            default:
                $discount = $reward->value ?? 0;
        }

        return response()->json([
            'success' => true,
            'voucher' => [
                'code' => $redemption->voucher_code,
                'reward_name' => $reward->name,
                'reward_type' => $reward->type,
                'reward_value' => $reward->value,
                'expires_at' => $redemption->expires_at->format('Y-m-d H:i:s'),
            ],
            'discount' => $discount,
            'message' => 'Voucher is valid and ready to use!'
        ]);
    }
}
