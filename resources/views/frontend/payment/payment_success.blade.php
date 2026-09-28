@extends('layouts.frontend_layout')

@section('title')
    AgroBd - Payment Confirmed
@endsection

@section('frontend_content')
    <section class="container mt-5 mb-5 pt-3">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">

                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        @php
                            $isPending = strtolower($payment->status) !== 'completed';
                        @endphp

                        <div class="text-center mb-4">
                            <i class="fas fa-check-circle" style="font-size: 80px; color: {{ $isPending ? '#f0ad4e' : '#81B622' }};"></i>
                            <h2 class="mt-3">{{ $isPending ? 'Order Placed' : 'Payment Confirmed!' }}</h2>
                            <p class="text-muted">{{ $isPending ? 'Your hand-cash order has been recorded and is awaiting seller confirmation.' : 'Your payment has been successfully recorded.' }}</p>
                        </div>

                        <hr>

                        <!-- Payment Confirmation Details -->
                        <div class="alert alert-light border">
                            <h5 class="mb-3"><strong>Order Details</strong></h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Product:</strong> {{ $business->product_name }}</p>
                                    <p><strong>Seller:</strong> {{ $business->name }}</p>
                                    <p><strong>Quantity:</strong> {{ $quantity }} kg</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Price per kg:</strong> ৳{{ $business->price }}</p>
                                    <p><strong>Payment Method:</strong> {{ $payment_method }}</p>
                                    <p class="fs-5"><strong style="color: #81B622;">Total Amount:
                                            ৳{{ $payment->amount }}</strong></p>
                                </div>
                            </div>
                        </div>

                        <hr>

                        @if ($isPending)
                            <div class="alert alert-warning">
                                <strong>পেমেন্ট স্ট্যাটাস:</strong> পেন্ডিং। আপনার আগের চেষ্টা সফল হয়নি বা এখনও নিশ্চিত হয়নি।
                                <a href="{{ url('business_payment/' . $business->id) . '?retry=1&quantity=' . $quantity }}" class="btn btn-outline-warning btn-sm ms-2">Retry payment</a>
                            </div>
                        @endif

                        <!-- Payment Confirmation -->
                        <div class="alert alert-{{ $isPending ? 'warning' : 'success' }} border-0" style="background: {{ $isPending ? '#fff3cd' : '#d4edda' }};">
                            <h5 class="mb-3"><i class="fas fa-clipboard-check"></i> <strong>{{ $isPending ? 'Order Status' : 'Payment Confirmation' }}</strong>
                            </h5>

                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td><strong>Transaction ID:</strong></td>
                                    <td><code>{{ $payment->transaction_id }}</code></td>
                                </tr>
                                <tr>
                                    <td><strong>Reference Number:</strong></td>
                                    <td><code>{{ $transaction_ref }}</code></td>
                                </tr>
                                <tr>
                                    <td><strong>Payment Status:</strong></td>
                                    <td><span class="badge bg-{{ $isPending ? 'warning text-dark' : 'success' }}">{{ $payment->status }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Confirmation Time:</strong></td>
                                    <td>{{ now()->format('d M Y, H:i A') }}</td>
                                </tr>
                            </table>

                            @if ($isPending)
                                <div class="alert alert-info mt-3">
                                    <p class="mb-0"><strong>Next Step:</strong> Seller confirmation is required before this order is marked as completed. You can check the status in your order history.</p>
                                </div>
                            @endif
                        </div>

                        <hr>

                        <!-- What's Next -->
                        <div class="alert alert-info border-0" style="background: #d1ecf1;">
                            <h5 class="mb-3"><i class="fas fa-arrow-right"></i> <strong>What's Next?</strong></h5>
                            <ul class="mb-0">
                                <li><strong>Seller Notification:</strong> The seller has been notified of your order and will confirm payment soon.</li>
                                <li><strong>Order Tracking:</strong> You can track your order status in "My Orders"</li>
                                <li><strong>Confirmation Email:</strong> A confirmation email has been sent to
                                    {{ $payment->email }}</li>
                                <li><strong>Delivery:</strong> The seller will arrange delivery as per their process once the payment is confirmed.</li>
                            </ul>
                        </div>

                        <hr>

                        <!-- Important Notes -->
                        <div class="alert alert-warning border-0" style="background: #fff3cd;">
                            <h5 class="mb-2"><i class="fas fa-exclamation-triangle"></i> Important Information</h5>
                            <ul class="mb-0">
                                <li>Please save your transaction reference and confirmation details</li>
                                <li>In case of any issues, contact seller or our support team with these details</li>
                                <li>Do not make duplicate payments</li>
                                <li>If seller doesn't confirm receipt within 24 hours, you can raise a complaint</li>
                            </ul>
                        </div>

                        <hr>

                        <div class="d-flex gap-2 justify-content-between">
                            <a href="{{ url('/') }}" class="btn btn-secondary">
                                <i class="fas fa-home"></i> Back to Home
                            </a>
                            <a href="{{ $payment_method === 'Hand Cash' ? url('/my_order_payment?type=handcash') : url('/my_order_payment?type=online') }}" class="btn btn-primary">
                                <i class="fas fa-list"></i> View My Orders
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
