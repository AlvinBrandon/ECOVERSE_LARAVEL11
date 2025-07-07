@extends('layouts.app')

@section('content')
<style>
  .invoice-box {
    max-width: 700px;
    margin: 40px auto;
    padding: 30px;
    border-radius: 1.25rem;
    background: #fff;
    box-shadow: 0 6px 32px rgba(16, 185, 129, 0.10);
    font-size: 1.1rem;
    color: #374151;
  }
  .invoice-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
  }
  .invoice-logo {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: #f0fdfa;
    border: 2px solid #10b981;
    object-fit: cover;
  }
  .invoice-title {
    font-size: 2rem;
    font-weight: 700;
    color: #10b981;
    margin-bottom: 0;
  }
  .invoice-table th, .invoice-table td {
    padding: 0.75rem 1rem;
    border: none;
  }
  .invoice-table th {
    background: #e0e7ff;
    color: #6366f1;
    font-weight: 600;
  }
  .invoice-table td {
    background: #f0fdfa;
  }
  .invoice-total {
    font-size: 1.2rem;
    font-weight: 700;
    color: #10b981;
  }
  .invoice-footer {
    margin-top: 2rem;
    font-size: 0.95rem;
    color: #6b7280;
    text-align: center;
  }
  @media print {
    .no-print { display: none !important; }
    .invoice-box { box-shadow: none; border: none; }
  }
</style>
<div class="invoice-box">
  <div class="invoice-header">
    <img src="/assets/img/ecoverse-logo.svg" alt="Ecoverse Logo" class="invoice-logo">
    <div>
      <div class="invoice-title">Ecoverse Invoice</div>
      <div class="text-muted">#{{ $sale->id }} &mdash; {{ $sale->created_at->format('Y-m-d H:i') }}</div>
    </div>
  </div>
  <hr>
  <div class="mb-3">
    <strong>Product:</strong> {{ $sale->product->name }}<br>
    <strong>Description:</strong> {{ $sale->product->description }}<br>
    <strong>Type:</strong> {{ $sale->product->type }}
  </div>
  <table class="table invoice-table mb-4">
    <thead>
      <tr>
        <th>Quantity</th>
        <th>Unit Price</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>{{ $sale->quantity }}</td>
        <td>UGX {{ number_format($sale->product->price) }}</td>
        <td class="invoice-total">UGX {{ number_format($sale->total_price) }}</td>
      </tr>
    </tbody>
  </table>
  <div class="mb-3">
    <strong>Sold By:</strong> {{ $sale->user->name ?? 'N/A' }}<br>
    <strong>Status:</strong> <span class="badge bg-gradient-success">{{ ucfirst($sale->status) }}</span>
  </div>
  <div class="no-print mt-4 d-flex gap-2">
    <a href="javascript:window.print()" class="btn btn-success"><i class="bi bi-printer me-1"></i> Print</a>
    <a href="{{ url()->previous() }}" class="btn btn-outline-dark">Back</a>
  </div>
  <div class="invoice-footer mt-4">
    Thank you for choosing Ecoverse. For support, contact us at info@ecoverse.com
  </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
@endsection
