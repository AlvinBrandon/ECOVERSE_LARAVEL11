<!-- =============================== -->
<!-- 1. Inventory Index (inventory/index.blade.php) -->
<!-- =============================== -->
@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
  <div class="row mb-4">
    <div class="col-12">
      <h4 class="text-dark">Inventory Dashboard</h4>
      <a href="{{ route('inventory.create') }}" class="btn btn-success mt-3">Add Stock</a>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-12">
      <canvas id="inventoryChart" height="100"></canvas>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header pb-0">
          <h6>Current Inventory</h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Product</th>
                  <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Batch ID</th>
                  <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Available Quantity</th>
                  <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Last Updated</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($inventory as $item)
                <tr>
                  <td>{{ $item->product->name }}</td>
                  <td>{{ $item->batch_id ?? 'N/A' }}</td>
                  <td>
                    {{ $item->quantity }}
                    @if ($item->quantity < 10)
                      <span class="text-danger font-weight-bold">(Low)</span>
                    @endif
                  </td>
                  <td>{{ $item->updated_at->format('Y-m-d H:i') }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('inventoryChart').getContext('2d');
  const inventoryChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [
        @foreach ($inventory as $item)
          '{{ $item->product->name }}',
        @endforeach
      ],
      datasets: [{
        label: 'Stock Quantity',
        data: [
          @foreach ($inventory as $item)
            {{ $item->quantity }},
          @endforeach
        ],
        backgroundColor: '#10b981',
        borderRadius: 6
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false },
        title: {
          display: true,
          text: 'Inventory Stock Levels by Product'
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 5
          }
        }
      }
    }
  });
</script>
@endsection


