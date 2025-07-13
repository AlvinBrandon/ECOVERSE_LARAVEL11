<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='raw-materials'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Raw Material Details"></x-navbars.navs.auth>
        <!-- End Navbar -->
        
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-6">
                                    <h6>Material Details</h6>
                                    <p class="text-sm mb-0">Information about "{{ $rawMaterial->name }}"</p>
                                </div>
                                <div class="col-6 text-end">
                                    <a href="{{ route('raw-materials.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="material-icons">arrow_back</i> Back to List
                                    </a>
                                    <a href="{{ route('raw-materials.edit', $rawMaterial->id) }}" class="btn btn-primary btn-sm">
                                        <i class="material-icons">edit</i> Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="mb-3">Basic Information</h6>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="text-secondary">Material Name:</td>
                                            <td><strong>{{ $rawMaterial->name }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-secondary">Quantity:</td>
                                            <td><strong>{{ number_format($rawMaterial->quantity) }} {{ $rawMaterial->unit }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-secondary">Unit Price:</td>
                                            <td><strong>₦{{ number_format($rawMaterial->price_per_unit) }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-secondary">Total Value:</td>
                                            <td><strong>₦{{ number_format($rawMaterial->quantity * $rawMaterial->price_per_unit) }}</strong></td>
                                        </tr>
                                    </table>
                                </div>
                                
                                <div class="col-md-6">
                                    <h6 class="mb-3">Additional Details</h6>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td class="text-secondary">Material ID:</td>
                                            <td><strong>#{{ $rawMaterial->id }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-secondary">Supplier ID:</td>
                                            <td><strong>{{ $rawMaterial->supplier_id }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-secondary">Created:</td>
                                            <td><strong>{{ $rawMaterial->created_at->format('M d, Y H:i') }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td class="text-secondary">Last Updated:</td>
                                            <td><strong>{{ $rawMaterial->updated_at->format('M d, Y H:i') }}</strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            @if($rawMaterial->description)
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h6 class="mb-3">Description</h6>
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <p class="mb-0">{{ $rawMaterial->description }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="row mt-4">
                                <div class="col-12 text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('raw-materials.edit', $rawMaterial->id) }}" class="btn btn-primary">
                                            <i class="material-icons">edit</i> Edit Material
                                        </a>
                                        <form action="{{ route('raw-materials.destroy', $rawMaterial->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this material?')">
                                                <i class="material-icons">delete</i> Delete Material
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout> 