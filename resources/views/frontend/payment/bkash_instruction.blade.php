@extends('layouts.frontend_layout')

@section('title')
    AgroBd - bKash Payment Instructions
@endsection

@section('frontend_content')
    <section class="container mt-5 mb-5 pt-3">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">

                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="fas fa-check-circle" style="font-size: 60px; color: #81B622;"></i>
                            <h2 class="mt-3">Payment Instructions</h2>
                            <p class="text-muted">Follow these steps to complete your payment via bKash</p>
                        </div>

                        <hr>

                        <!-- Payment Summary -->
                        <div class="alert alert-light border">
                            <h5 class="mb-3"><strong>Payment Summary</strong></h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Product:</strong> {{ $business->product_name }}</p>
                                    <p><strong>Seller:</strong> {{ $business->name }}</p>
                                    <p><strong>Quantity:</strong> {{ $quantity }} kg</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Price per kg:</strong> ৳{{ $business->price }}</p>
                                    <p><strong>Transaction ID:</strong> <code>{{ $tran_id }}</code></p>
                                    <p class="fs-5"><strong style="color: #81B622;">Total Amount:
                                            ৳{{ $amount }}</strong></p>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- bKash Payment Steps -->
                        <div class="alert alert-info border-0" style="background: #d1ecf1;">
                            <h5 class="mb-3"><strong>How to Pay via bKash</strong></h5>

                            <div class="step mb-3">
                                <h6><span class="badge badge-success">Step 1</span> Open bKash App</h6>
                                <p class="text-muted ms-4">Open the bKash mobile app or dial <strong>*247# → 1 → 1</strong>
                                </p>
                            </div>

                            <div class="step mb-3">
                                <h6><span class="badge badge-success">Step 2</span> Send Money</h6>
                                <p class="text-muted ms-4">Choose "Money Transfer" or "Send Money to Others"</p>
                            </div>

                            <div class="step mb-3">
                                <h6><span class="badge badge-success">Step 3</span> Enter Recipient Number</h6>
                                <p class="ms-4"
                                    style="background: #fff; padding: 10px; border-radius: 5px; border-left: 4px solid #81B622;">
                                    <strong>Recipient bKash Number:</strong><br>
                                    <span
                                        style="font-size: 18px; font-weight: bold; color: #81B622;">{{ $business->bkash_number }}</span>
                                </p>
                            </div>

                            <div class="step mb-3">
                                <h6><span class="badge badge-success">Step 4</span> Enter Amount</h6>
                                <p class="ms-4"
                                    style="background: #fff; padding: 10px; border-radius: 5px; border-left: 4px solid #81B622;">
                                    <strong>Amount to Transfer:</strong><br>
                                    <span
                                        style="font-size: 18px; font-weight: bold; color: #81B622;">৳{{ $amount }}</span>
                                </p>
                            </div>

                            <div class="step">
                                <h6><span class="badge badge-success">Step 5</span> Confirm Payment</h6>
                                <p class="text-muted ms-4">Enter your bKash PIN to confirm the transaction</p>
                                <p class="text-muted ms-4">Save the transaction reference number for your records</p>
                            </div>
                        </div>

                        <hr>

                        <!-- Important Notes -->
                        <div class="alert alert-warning border-0" style="background: #fff3cd;">
                            <h5 class="mb-2"><i class="fas fa-exclamation-triangle"></i> Important Notes</h5>
                            <ul class="mb-0">
                                <li>Please transfer the <strong>exact amount (৳{{ $amount }})</strong></li>
                                <li>Your Transaction ID is: <strong>{{ $tran_id }}</strong> - Please mention this in
                                    bKash reference if possible</li>
                                <li>After payment, your order status will be updated to "Confirmed"</li>
                                <li>The seller will be notified and begin processing your order</li>
                                <li>If you face any issues, contact our support team</li>
                            </ul>
                        </div>

                        <hr>

                        <div class="alert alert-warning border-0" style="background: #fff3cd;">
                            <h5 class="mb-2"><i class="fas fa-sync-alt"></i> Payment Status & Retry</h5>
                            <p class="mb-2">আপনার পেমেন্ট এখন পেন্ডিং অবস্থায় আছে। যদি কিছু সমস্যা হয়, তাহলে আবার চেষ্টা করতে পারেন।</p>
                            <a href="{{ url('business_payment/' . $business->id) . '?retry=1&quantity=' . $quantity }}" class="btn btn-outline-warning">Retry payment</a>
                        </div>

                        <hr>

                        <!-- Payment Confirmation Form -->
                        <div class="alert alert-success border-0" style="background: #d4edda;">
                            <h5 class="mb-3"><i class="fas fa-clipboard-check"></i> <strong>After Payment - Confirm
                                    Transaction</strong></h5>
                            <p class="text-muted mb-3">Once you've successfully sent the money to the seller's bKash
                                account, enter your bKash transaction reference number below to confirm the payment:</p>

                            <form action="{{ url('confirm-bkash-payment') }}" method="POST">
                                @csrf
                                <input type="hidden" name="transaction_id" value="{{ $tran_id }}">
                                <input type="hidden" name="business_id" value="{{ $business->id }}">
                                <input type="hidden" name="amount" value="{{ $amount }}">
                                <input type="hidden" name="quantity" value="{{ $quantity }}">

                                <div class="form-group mb-3">
                                    <label class="form-label"><strong>bKash Transaction Reference:</strong></label>
                                    <input type="text" name="bkash_transaction_ref" class="form-control"
                                        placeholder="Enter your bKash ref (e.g., TR-3048-xxxx-xxxx)" required>
                                    <small class="text-muted">You received this after making the payment</small>
                                </div>

                                <button type="submit" class="btn btn-success btn-lg w-100">
                                    <i class="fas fa-check"></i> Confirm Payment
                                </button>
                            </form>
                        </div>

                        <hr>

                        <div class="d-flex gap-2 justify-content-between">
                            <a href="{{ url('/') }}" class="btn btn-secondary">
                                <i class="fas fa-home"></i> Back to Home
                            </a>
                            <a href="{{ url('/my_orders') }}" class="btn btn-primary">
                                <i class="fas fa-list"></i> View My Orders
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
