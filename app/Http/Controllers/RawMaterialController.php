<?php

namespace App\Http\Controllers;

use App\Models\RawMaterial;
use Illuminate\Http\Request;

class RawMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = RawMaterial::query();
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where('name', 'like', "%$search%")
              ->orWhere('type', 'like', "%$search%");
    }
    $rawMaterials = $query->orderBy('name')->paginate(10);
    $totalCount = RawMaterial::count();
    $totalQuantity = RawMaterial::sum('quantity');
    $lowStockCount = RawMaterial::whereColumn('quantity', '<=', 'reorder_level')->count();
    $typeCount = RawMaterial::distinct('type')->count('type');
    // Render the supplier view for raw material management
    return view('supplier.raw-materials', compact('rawMaterials', 'totalCount', 'totalQuantity', 'lowStockCount', 'typeCount'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Render the supplier-specific create form
        return view('supplier.raw-materials-create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        'name' => 'required|string|max:255',
        'type' => 'required|string|max:255',
        'unit' => 'required|string|max:50',
        'quantity' => 'required|integer|min:0',
        'reorder_level' => 'required|integer|min:0',
        'description' => 'nullable|string|max:1000',
    ]);
    RawMaterial::create($validated);
    return redirect()->route('raw-materials.index')->with('success', 'Raw material added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RawMaterial $rawMaterial)
    {
        return view('raw_materials.show', compact('rawMaterial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RawMaterial $rawMaterial)
    {
        return view('raw_materials.edit', compact('rawMaterial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RawMaterial $rawMaterial)
    {
        $validated = $request->validate([
        'name' => 'required|string|max:255',
        'type' => 'required|string|max:255',
        'unit' => 'required|string|max:50',
        'quantity' => 'required|integer|min:0',
        'reorder_level' => 'required|integer|min:0',
        'description' => 'nullable|string|max:1000',
    ]);
    $rawMaterial->update($validated);
    return redirect()->route('raw-materials.index')->with('success', 'Raw material updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RawMaterial $rawMaterial)
    {
        $rawMaterial->delete();
    return redirect()->route('raw-materials.index')->with('success', 'Raw material deleted successfully.');
    }
}
