<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='raw-materials'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Add Raw Material"></x-navbars.navs.auth>
        <!-- End Navbar -->
        
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-6">
                                    <h6>Add New Raw Material</h6>
                                    <p class="text-sm mb-0">Enter the details of the new raw material</p>
                                </div>
                                <div class="col-6 text-end">
                                    <a href="{{ route('raw-materials.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="material-icons">arrow_back</i> Back to List
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('raw-materials.store') }}" method="POST">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Material Name *</label>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Quantity *</label>
                                            <input type="number" name="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}" min="0" step="0.01" required>
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
                                                <option value="kg" {{ old('unit') == 'kg' ? 'selected' : '' }}>Kilograms (kg)</option>
                                                <option value="g" {{ old('unit') == 'g' ? 'selected' : '' }}>Grams (g)</option>
                                                <option value="l" {{ old('unit') == 'l' ? 'selected' : '' }}>Liters (l)</option>
                                                <option value="ml" {{ old('unit') == 'ml' ? 'selected' : '' }}>Milliliters (ml)</option>
                                                <option value="pcs" {{ old('unit') == 'pcs' ? 'selected' : '' }}>Pieces (pcs)</option>
                                                <option value="m" {{ old('unit') == 'm' ? 'selected' : '' }}>Meters (m)</option>
                                                <option value="cm" {{ old('unit') == 'cm' ? 'selected' : '' }}>Centimeters (cm)</option>
                                                <option value="boxes" {{ old('unit') == 'boxes' ? 'selected' : '' }}>Boxes</option>
                                                <option value="bags" {{ old('unit') == 'bags' ? 'selected' : '' }}>Bags</option>
                                                <option value="rolls" {{ old('unit') == 'rolls' ? 'selected' : '' }}>Rolls</option>
                                            </select>
                                            @error('unit')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Price per Unit (₦) *</label>
                                            <input type="number" name="price_per_unit" class="form-control @error('price_per_unit') is-invalid @enderror" value="{{ old('price_per_unit') }}" min="0" step="0.01" required>
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
                                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Enter a detailed description of the material...">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Additional Fields -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Minimum Stock Level</label>
                                            <input type="number" name="min_stock" class="form-control @error('min_stock') is-invalid @enderror" value="{{ old('min_stock') }}" min="0" step="0.01">
                                            @error('min_stock')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Supplier Code</label>
                                            <input type="text" name="supplier_code" class="form-control @error('supplier_code') is-invalid @enderror" value="{{ old('supplier_code') }}" placeholder="Optional internal code">
                                            @error('supplier_code')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Material Properties -->
                                <div class="row">
                                    <div class="col-12">
                                        <h6 class="mb-3">Material Properties</h6>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Color</label>
                                            <input type="text" name="color" class="form-control @error('color') is-invalid @enderror" value="{{ old('color') }}">
                                            @error('color')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Grade</label>
                                            <input type="text" name="grade" class="form-control @error('grade') is-invalid @enderror" value="{{ old('grade') }}" placeholder="e.g., A, B, Premium">
                                            @error('grade')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Size</label>
                                            <input type="text" name="size" class="form-control @error('size') is-invalid @enderror" value="{{ old('size') }}" placeholder="e.g., 10mm, Large">
                                            @error('size')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Storage Information -->
                                <div class="row">
                                    <div class="col-12">
                                        <h6 class="mb-3">Storage Information</h6>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Storage Location</label>
                                            <input type="text" name="storage_location" class="form-control @error('storage_location') is-invalid @enderror" value="{{ old('storage_location') }}" placeholder="e.g., Warehouse A, Shelf 3">
                                            @error('storage_location')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="input-group input-group-outline mb-3">
                                            <label class="form-label">Storage Conditions</label>
                                            <select name="storage_conditions" class="form-control @error('storage_conditions') is-invalid @enderror">
                                                <option value="">Select Conditions</option>
                                                <option value="room_temp" {{ old('storage_conditions') == 'room_temp' ? 'selected' : '' }}>Room Temperature</option>
                                                <option value="refrigerated" {{ old('storage_conditions') == 'refrigerated' ? 'selected' : '' }}>Refrigerated</option>
                                                <option value="frozen" {{ old('storage_conditions') == 'frozen' ? 'selected' : '' }}>Frozen</option>
                                                <option value="dry" {{ old('storage_conditions') == 'dry' ? 'selected' : '' }}>Dry Storage</option>
                                                <option value="humid" {{ old('storage_conditions') == 'humid' ? 'selected' : '' }}>Humid Storage</option>
                                            </select>
                                            @error('storage_conditions')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" name="hazardous" id="hazardous" {{ old('hazardous') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="hazardous">
                                                This material is hazardous and requires special handling
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 text-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="material-icons">save</i> Add Material
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