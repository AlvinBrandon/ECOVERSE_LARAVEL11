<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='raw-materials'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Edit Raw Material"></x-navbars.navs.auth>
        <!-- End Navbar -->
        
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-6">
                                    <h6>Edit Raw Material</h6>
                                    <p class="text-sm mb-0">Update the details of "{{ $rawMaterial->name }}"</p>
                                </div>
                                <div class="col-6 text-end">
                                    <a href="{{ route('raw-materials.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="material-icons">arrow_back</i> Back to List
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('raw-materials.update', $rawMaterial->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Material Name *</label>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $rawMaterial->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Quantity *</label>
                                            <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', $rawMaterial->quantity) }}" min="0" step="0.01" required>
                                            @error('quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Unit *</label>
                                            <select name="unit" class="form-control @error('unit') is-invalid @enderror" required>
                                                <option value="">Select Unit</option>
                                                <option value="kg" {{ (old('unit', $rawMaterial->unit) == 'kg') ? 'selected' : '' }}>Kilograms (kg)</option>
                                                <option value="g" {{ (old('unit', $rawMaterial->unit) == 'g') ? 'selected' : '' }}>Grams (g)</option>
                                                <option value="l" {{ (old('unit', $rawMaterial->unit) == 'l') ? 'selected' : '' }}>Liters (l)</option>
                                                <option value="ml" {{ (old('unit', $rawMaterial->unit) == 'ml') ? 'selected' : '' }}>Milliliters (ml)</option>
                                                <option value="pcs" {{ (old('unit', $rawMaterial->unit) == 'pcs') ? 'selected' : '' }}>Pieces (pcs)</option>
                                                <option value="m" {{ (old('unit', $rawMaterial->unit) == 'm') ? 'selected' : '' }}>Meters (m)</option>
                                                <option value="cm" {{ (old('unit', $rawMaterial->unit) == 'cm') ? 'selected' : '' }}>Centimeters (cm)</option>
                                                <option value="boxes" {{ (old('unit', $rawMaterial->unit) == 'boxes') ? 'selected' : '' }}>Boxes</option>
                                                <option value="bags" {{ (old('unit', $rawMaterial->unit) == 'bags') ? 'selected' : '' }}>Bags</option>
                                                <option value="rolls" {{ (old('unit', $rawMaterial->unit) == 'rolls') ? 'selected' : '' }}>Rolls</option>
                                            </select>
                                            @error('unit')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Price per Unit (₦) *</label>
                                            <input type="number" name="price_per_unit" class="form-control @error('price_per_unit') is-invalid @enderror" value="{{ old('price_per_unit', $rawMaterial->price_per_unit) }}" min="0" step="0.01" required>
                                            @error('price_per_unit')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Description</label>
                                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Enter a detailed description of the material...">{{ old('description', $rawMaterial->description) }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="material-icons">update</i> Update Material
                                        </button>
                                        <a href="{{ route('raw-materials.index') }}" class="btn btn-secondary">
                                            Cancel
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout> 