@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h3 class="mb-4 text-success"><i class="bi bi-bag-check me-2"></i>Order Placed Successfully!</h3>
                    <h5 class="mb-3">Order Summary</h5>
                    <div class="table-responsive mb-4">
                        <table class="table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Image</th>
                                    <th>Unit Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order['items'] as $item)
                                <tr>
                                    <td>{{ $item['name'] }}</td>
                                    <td>
                                        @if($item['image'])
                                            <img src="/assets/img/products/{{ $item['image'] }}" alt="{{ $item['name'] }}" style="max-width:50px;max-height:50px;object-fit:contain;">
                                        @endif
                                    </td>
                                    <td>UGX {{ number_format($item['price']) }}</td>
                                    <td>{{ $item['quantity'] }}</td>
                                    <td>UGX {{ number_format($item['price'] * $item['quantity']) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-end">Grand Total:</th>
                                    <th>UGX {{ number_format($order['total']) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="mb-3">
                        <strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $order['payment_method'])) }}<br>
                        @if($order['payment_method'] === 'mobile_money')
                            <strong>Provider:</strong> {{ strtoupper($order['payment_details']['provider']) }}<br>
                            <strong>Phone:</strong> {{ $order['payment_details']['phone'] }}<br>
                        @elseif($order['payment_method'] === 'visa_card')
                            <strong>Card Number:</strong> **** **** **** **** {{ substr($order['payment_details']['card_number'], -4) }}<br>
                        @endif
                        <strong>Delivery Address:</strong> {{ $order['address'] }}<br>
                        <strong>Order Date:</strong> {{ $order['created_at'] }}
                    </div>
                    <hr>
                    <h5 class="mb-3">Order Status</h5>
                    <div class="d-flex align-items-center justify-content-between" style="max-width:500px;margin:auto;">
                        <div class="text-center">
                            <div class="bg-success text-white rounded-circle mb-2" style="width:48px;height:48px;display:flex;align-items:center;justify-content:center;font-size:2rem;"><i class="bi bi-check-circle"></i></div>
                            <div>Order Placed</div>
                        </div>
                        <div class="flex-grow-1 border-top border-3 mx-2" style="border-color:#ccc !important;"></div>
                        <div class="text-center">
                            <div class="bg-light text-secondary rounded-circle mb-2" style="width:48px;height:48px;display:flex;align-items:center;justify-content:center;font-size:2rem;"><i class="bi bi-truck"></i></div>
                            <div>Out for Delivery</div>
                        </div>
                        <div class="flex-grow-1 border-top border-3 mx-2" style="border-color:#ccc !important;"></div>
                        <div class="text-center">
                            <div class="bg-light text-secondary rounded-circle mb-2" style="width:48px;height:48px;display:flex;align-items:center;justify-content:center;font-size:2rem;"><i class="bi bi-emoji-smile"></i></div>
                            <div>Delivered</div>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <a href="/dashboard" class="btn btn-outline-success me-2"><i class="bi bi-house-door me-1"></i>Home</a>
                        <a href="{{ route('sales.status') }}" class="btn btn-primary"><i class="bi bi-clipboard-check me-1"></i>View Order Status</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 