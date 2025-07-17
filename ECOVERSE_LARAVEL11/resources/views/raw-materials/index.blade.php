<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage='raw-materials'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Raw Materials"></x-navbars.navs.auth>
        <!-- End Navbar -->
        
        <div class="container-fluid py-4">
            <!-- Header with Add Button -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-lg-6 col-7">
                                    <h6>Raw Materials Inventory</h6>
                                    <p class="text-sm mb-0">
                                        <i class="fa fa-check text-info" aria-hidden="true"></i>
                                        <span class="font-weight-bold ms-1">{{ $rawMaterials->count() }} materials</span> in stock
                                    </p>
                                </div>
                                <div class="col-lg-6 col-5 my-auto text-end">
                                    <a href="{{ route('raw-materials.create') }}" class="btn btn-primary btn-sm">
                                        <i class="material-icons">add</i> Add New Material
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
            <div class="row mb-4">
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                        <span class="alert-text">{{ session('success') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
            @endif

            <!-- Raw Materials Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h6>Materials List</h6>
                        </div>
                        <div class="card-body px-0 pt-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Material</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Quantity</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Unit Price</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Value</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Last Updated</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($rawMaterials as $material)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $material->name }}</h6>
                                                        <p class="text-xs text-secondary mb-0">ID: #{{ $material->id }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-xs font-weight-bold mb-0">{{ number_format($material->quantity) }} {{ $material->unit }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <span class="badge badge-sm bg-gradient-success">₦{{ number_format($material->price_per_unit) }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">₦{{ number_format($material->quantity * $material->price_per_unit) }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <span class="text-secondary text-xs font-weight-bold">{{ $material->updated_at->diffForHumans() }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('raw-materials.show', $material->id) }}" class="btn btn-link text-secondary px-3 mb-0" data-toggle="tooltip" data-original-title="View details">
                                                        <i class="material-icons text-sm me-2">visibility</i>View
                                                    </a>
                                                    <a href="{{ route('raw-materials.edit', $material->id) }}" class="btn btn-link text-secondary px-3 mb-0" data-toggle="tooltip" data-original-title="Edit material">
                                                        <i class="material-icons text-sm me-2">edit</i>Edit
                                                    </a>
                                                    <form action="{{ route('raw-materials.destroy', $material->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link text-danger px-3 mb-0" onclick="return confirm('Are you sure you want to delete this material?')" data-toggle="tooltip" data-original-title="Delete material">
                                                            <i class="material-icons text-sm me-2">delete</i>Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="row mt-4">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">inventory</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Total Materials</p>
                                <h4 class="mb-0">{{ $rawMaterials->count() }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0"><span class="text-success text-sm font-weight-bolder">Active</span> materials</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">scale</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Total Quantity</p>
                                <h4 class="mb-0">{{ number_format($rawMaterials->sum('quantity')) }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0">Combined units</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-warning shadow-warning text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">payments</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Total Value</p>
                                <h4 class="mb-0">₦{{ number_format($rawMaterials->sum(function($m) { return $m->quantity * $m->price_per_unit; })) }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0">Inventory value</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-header p-3 pt-2">
                            <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                                <i class="material-icons opacity-10">trending_up</i>
                            </div>
                            <div class="text-end pt-1">
                                <p class="text-sm mb-0 text-capitalize">Avg Price</p>
                                <h4 class="mb-0">₦{{ number_format($rawMaterials->avg('price_per_unit')) }}</h4>
                            </div>
                        </div>
                        <hr class="dark horizontal my-0">
                        <div class="card-footer p-3">
                            <p class="mb-0">Per unit average</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout> 