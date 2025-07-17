<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class SalesController extends Controller
{
    /**
     * Display the sales index page.
     */
    public function index(): View
    {
        return view('sales.index');
    }

    /**
     * Store a new sale.
     */
    public function store(Request $request)
    {
        // TODO: Implement sale storage logic
        return redirect()->route('sales.index')->with('success', 'Sale created successfully');
    }

    /**
     * Display sales history.
     */
    public function history(): View
    {
        return view('sales.history');
    }

    /**
     * Display sales status.
     */
    public function status(): View
    {
        return view('sales.status');
    }

    /**
     * Display sales analytics.
     */
    public function analytics(): View
    {
        return view('sales.analytics');
    }

    /**
     * Generate invoice for a sale.
     */
    public function invoice($id): View
    {
        return view('sales.invoice', compact('id'));
    }

    /**
     * Display admin sales report.
     */
    public function report(): View
    {
        return view('admin.sales.report');
    }
} 