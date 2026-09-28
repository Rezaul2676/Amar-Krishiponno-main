@extends('layouts.frontend_layout')

@section('title')
    AgroBd - Payment Success
@endsection

@section('frontend_content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 overflow-hidden">
                    <div class="bg-success text-white p-5 text-center">
                        <h1 class="display-5 mb-3">Payment Successful!</h1>
                        <p class="lead mb-0">Thank you for your order. Your payment has been processed successfully.</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="row text-center mb-4">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <div class="p-3 rounded bg-light">
                                    <h6 class="text-muted">Status</h6>
                                    <p class="mb-0 text-success fw-bold">{{ $status_text }}</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <div class="p-3 rounded bg-light">
                                    <h6 class="text-muted">Amount</h6>
                                    <p class="mb-0 fw-bold">{{ $amount ?? '-' }} {{ $currency ?? '' }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 rounded bg-light">
                                    <h6 class="text-muted">Transaction ID</h6>
                                    <p class="mb-0 text-break">{{ $tran_id ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5 class="mb-3">What happens next?</h5>
                            <p class="text-muted">Your transaction has been recorded. Our seller will contact you shortly to
                                confirm the delivery details.</p>
                        </div>

                        @if (!empty($message))
                            <div class="alert alert-info" role="alert">
                                {{ $message }}
                            </div>
                        @endif

                        <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                            <a href="{{ url('my_business') }}" class="btn btn-success btn-lg px-4">Go to MyBusiness</a>
                            <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-lg px-4">Return Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
