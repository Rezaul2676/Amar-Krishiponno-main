@extends('layouts.frontend_layout')

@section('title')
    AgroBd - Bank Transfer Instructions
@endsection

@section('frontend_content')
    <section class="container mt-5 mb-5 pt-3">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">

                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="fas fa-university" style="font-size: 60px; color: #81B622;"></i>
                            <h2 class="mt-3">Bank Transfer Instructions</h2>
                            <p class="text-muted">Follow these steps to complete your payment via Bank Transfer</p>
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

                        <!-- Bank Details -->
                        <div class="alert alert-info border-0" style="background: #d1ecf1;">
                            <h5 class="mb-4"><strong>Bank Account Details</strong></h5>

                            <div class="mb-4"
                                style="background: #fff; padding: 15px; border-radius: 5px; border-left: 4px solid #81B622;">
                                <p class="mb-2"><strong>Bank Name:</strong></p>
                                <span
                                    style="font-size: 16px; font-weight: bold; color: #81B622;">{{ $business->bank_name }}</span>
                            </div>

                            <div class="mb-4"
                                style="background: #fff; padding: 15px; border-radius: 5px; border-left: 4px solid #81B622;">
                                <p class="mb-2"><strong>Account Number:</strong></p>
                                <span
                                    style="font-size: 16px; font-weight: bold; color: #81B622;">{{ $business->bank_account }}</span>
                            </div>

                            <div class="mb-4"
                                style="background: #fff; padding: 15px; border-radius: 5px; border-left: 4px solid #81B622;">
                                <p class="mb-2"><strong>Routing/Branch Code:</strong></p>
                                <span
                                    style="font-size: 16px; font-weight: bold; color: #81B622;">{{ $business->bank_routing }}</span>
                            </div>

                            <div
                                style="background: #fff; padding: 15px; border-radius: 5px; border-left: 4px solid #81B622;">
                                <p class="mb-2"><strong>Amount to Transfer:</strong></p>
                                <span
                                    style="font-size: 18px; font-weight: bold; color: #81B622;">৳{{ $amount }}</span>
                            </div>
                        </div>

                        <hr>

                        <!-- Bank Transfer Steps -->
                        <div class="alert alert-success border-0" style="background: #d4edda;">
                            <h5 class="mb-3"><strong>How to Make Bank Transfer</strong></h5>

                            <div class="step mb-3">
                                <h6><span class="badge badge-primary">Step 1</span> Visit Your Bank</h6>
                                <p class="text-muted ms-4">Visit your bank branch or use online banking portal</p>
                            </div>

                            <div class="step mb-3">
                                <h6><span class="badge badge-primary">Step 2</span> Select Fund Transfer</h6>
                                <p class="text-muted ms-4">Choose "Funds Transfer" or "Send Money to Other Account"</p>
                            </div>

                            <div class="step mb-3">
                                <h6><span class="badge badge-primary">Step 3</span> Enter Account Details</h6>
                                <p class="text-muted ms-4">
                                    Bank: {{ $business->bank_name }}<br>
                                    Account: {{ $business->bank_account }}<br>
                                    Routing: {{ $business->bank_routing }}
                                </p>
                            </div>

                            <div class="step mb-3">
                                <h6><span class="badge badge-primary">Step 4</span> Enter Transfer Amount</h6>
                                <p class="text-muted ms-4"><strong>Amount: ৳{{ $amount }}</strong></p>
                            </div>

                            <div class="step">
                                <h6><span class="badge badge-primary">Step 5</span> Add Reference</h6>
                                <p class="text-muted ms-4">In the reference/description field, write:
                                    <strong>{{ $tran_id }}</strong>
                                </p>
                                <p class="text-muted ms-4">This helps us identify your payment quickly</p>
                            </div>
                        </div>

                        <hr>

                        <!-- Important Notes -->
                        <div class="alert alert-warning border-0" style="background: #fff3cd;">
                            <h5 class="mb-2"><i class="fas fa-exclamation-triangle"></i> Important Notes</h5>
                            <ul class="mb-0">
                                <li>Please transfer the <strong>exact amount (৳{{ $amount }})</strong></li>
                                <li>Your Transaction Reference ID is: <strong>{{ $tran_id }}</strong> - Please use
                                    this in bank transfer reference</li>
                                <li>Bank transfers may take 1-3 business days to process</li>
                                <li>Your order status will be updated once payment is confirmed</li>
                                <li>The seller will be notified and begin processing your order</li>
                                <li>Keep your bank receipt for your records</li>
                                <li>If payment is not reflected within 3 days, contact our support team</li>
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
                            <p class="text-muted mb-3">Once you've successfully transferred the money to the seller's bank
                                account, enter your bank transaction reference number below to confirm the payment:</p>

                            <form action="{{ url('confirm-bank-payment') }}" method="POST">
                                @csrf
                                <input type="hidden" name="transaction_id" value="{{ $tran_id }}">
                                <input type="hidden" name="business_id" value="{{ $business->id }}">
                                <input type="hidden" name="amount" value="{{ $amount }}">
                                <input type="hidden" name="quantity" value="{{ $quantity }}">

                                <div class="form-group mb-3">
                                    <label class="form-label"><strong>Bank Transaction Reference:</strong></label>
                                    <input type="text" name="bank_transaction_ref" class="form-control"
                                        placeholder="Enter your bank ref or check number (e.g., CHK-12345-XXXXX)" required>
                                    <small class="text-muted">You received this from your bank after transfer</small>
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
