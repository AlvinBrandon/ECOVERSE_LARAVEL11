@extends('layouts.app')
@section('content')
<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-lg">
        <div class="card-header bg-gradient-primary text-white">
          <h4 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Add New Raw Material</h4>
        </div>
        <div class="card-body">
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          <form method="POST" action="{{ route('raw-materials.store') }}">
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label">Material Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required maxlength="255">
            </div>
            <div class="mb-3">
              <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="type" name="type" value="{{ old('type') }}" required maxlength="255">
            </div>
            <div class="mb-3">
              <label for="unit" class="form-label">Unit <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="unit" name="unit" value="{{ old('unit') }}" required maxlength="50" placeholder="e.g. kg, liters">
            </div>
            <div class="mb-3">
              <label for="quantity" class="form-label">Initial Quantity <span class="text-danger">*</span></label>
              <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', 0) }}" required min="0">
            </div>
            <div class="mb-3">
              <label for="reorder_level" class="form-label">Reorder Level <span class="text-danger">*</span></label>
              <input type="number" class="form-control" id="reorder_level" name="reorder_level" value="{{ old('reorder_level', 0) }}" required min="0">
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" id="description" name="description" rows="3" maxlength="1000">{{ old('description') }}</textarea>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <a href="{{ route('raw-materials.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Cancel</a>
              <button type="submit" class="btn btn-success"><i class="bi bi-check-circle me-1"></i> Add Material</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
