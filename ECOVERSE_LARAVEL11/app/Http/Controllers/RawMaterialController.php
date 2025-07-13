<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class RawMaterialController extends Controller
{
    /**
     * Display a listing of raw materials.
     */
    public function index(): View
    {
        // Demo data - in a real app, this would come from database
        $rawMaterials = collect([
            (object)[
                'id' => 1,
                'name' => 'Plastic',
                'quantity' => 100,
                'unit' => 'kg',
                'price_per_unit' => 50,
                'supplier_id' => Auth::id(),
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(1)
            ],
            (object)[
                'id' => 2,
                'name' => 'Metal',
                'quantity' => 50,
                'unit' => 'kg',
                'price_per_unit' => 100,
                'supplier_id' => Auth::id(),
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(3)
            ],
            (object)[
                'id' => 3,
                'name' => 'Glass',
                'quantity' => 75,
                'unit' => 'kg',
                'price_per_unit' => 75,
                'supplier_id' => Auth::id(),
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(7)
            ]
        ]);

        return view('raw-materials.index', compact('rawMaterials'));
    }

    /**
     * Show the form for creating a new raw material.
     */
    public function create(): View
    {
        return view('raw-materials.create');
    }

    /**
     * Store a newly created raw material.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'price_per_unit' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
        ]);

        // In a real application, this would save to database
        // For now, we'll just redirect with success message
        
        return redirect()->route('raw-materials.index')
            ->with('success', 'Raw material "' . $request->name . '" added successfully!');
    }

    /**
     * Display the specified raw material.
     */
    public function show($id): View
    {
        // Demo data - in a real app, this would fetch from database
        $rawMaterial = (object)[
            'id' => $id,
            'name' => 'Sample Material',
            'quantity' => 100,
            'unit' => 'kg',
            'price_per_unit' => 50,
            'description' => 'This is a sample raw material description.',
            'supplier_id' => Auth::id(),
            'created_at' => now()->subDays(5),
            'updated_at' => now()->subDays(1)
        ];

        return view('raw-materials.show', compact('rawMaterial'));
    }

    /**
     * Show the form for editing the specified raw material.
     */
    public function edit($id): View
    {
        // Demo data - in a real app, this would fetch from database
        $rawMaterial = (object)[
            'id' => $id,
            'name' => 'Sample Material',
            'quantity' => 100,
            'unit' => 'kg',
            'price_per_unit' => 50,
            'description' => 'This is a sample raw material description.',
        ];

        return view('raw-materials.edit', compact('rawMaterial'));
    }

    /**
     * Update the specified raw material.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'price_per_unit' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
        ]);

        // In a real application, this would update the database
        // For now, we'll just redirect with success message
        
        return redirect()->route('raw-materials.index')
            ->with('success', 'Raw material "' . $request->name . '" updated successfully!');
    }

    /**
     * Remove the specified raw material.
     */
    public function destroy($id): RedirectResponse
    {
        // In a real application, this would delete from database
        // For now, we'll just redirect with success message
        
        return redirect()->route('raw-materials.index')
            ->with('success', 'Raw material deleted successfully!');
    }
} 