<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EcoPointTransaction;
use App\Services\EcoPointService;
use Illuminate\Support\Facades\Auth;

class EcoPointController extends Controller
{
    protected $ecoPointService;

    public function __construct(EcoPointService $ecoPointService)
    {
        $this->ecoPointService = $ecoPointService;
    }

    /**
     * Display eco points overview
     */
    public function index()
    {
        $stats = [
            'total_users_with_points' => User::where('eco_points', '>', 0)->count(),
            'total_points_distributed' => User::sum('eco_points'),
            'total_transactions' => EcoPointTransaction::count(),
            'recent_transactions' => EcoPointTransaction::with('user')
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get()
        ];

        $users = User::where('eco_points', '>', 0)
            ->orderBy('eco_points', 'desc')
            ->take(20)
            ->get();

        return view('admin.eco-points.index', compact('stats', 'users'));
    }

    /**
     * Show form to manually award points
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('admin.eco-points.create', compact('users'));
    }

    /**
     * Store manually awarded points
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'points' => 'required|integer|min:1',
            'description' => 'required|string|max:255'
        ]);

        $user = User::findOrFail($request->user_id);

        $this->ecoPointService->awardPoints(
            $user,
            $request->points,
            'manual',
            $request->description,
            ['awarded_by' => Auth::id()]
        );

        return redirect()->route('admin.eco-points.index')
            ->with('success', "Successfully awarded {$request->points} eco points to {$user->name}");
    }

    /**
     * Deduct points (for admin corrections)
     */
    public function deduct(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'points' => 'required|integer|min:1',
            'description' => 'required|string|max:255'
        ]);

        $user = User::findOrFail($request->user_id);

        try {
            $this->ecoPointService->deductPoints(
                $user,
                $request->points,
                'manual_deduction',
                $request->description,
                ['deducted_by' => auth::id()]
            );

            return redirect()->route('admin.eco-points.index')
                ->with('success', "Successfully deducted {$request->points} eco points from {$user->name}");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Show user's eco point history
     */
    public function userHistory($userId)
    {
        $user = User::findOrFail($userId);
        $transactions = EcoPointTransaction::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.eco-points.user-history', compact('user', 'transactions'));
    }
}
