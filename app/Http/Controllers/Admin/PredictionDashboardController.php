<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class PredictionDashboardController extends Controller
{
    /**
     * Show the predictions dashboard
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get unique product categories
        $categories = Product::distinct()
            ->whereNotNull('category')
            ->pluck('category')
            ->sort()
            ->values()
            ->toArray();

        return view('admin.predictions.dashboard', [
            'categories' => $categories
        ]);
    }
} 