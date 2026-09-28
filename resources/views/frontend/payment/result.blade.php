@extends('layouts.frontend_layout')

@section('title')
    AgroBd - Payment Result
@endsection

@section('frontend_content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 overflow-hidden">
                    <div class="text-center p-5"
                        style="background: linear-gradient(135deg, #0f9d58 0%, #34a853 100%); color: white;">
                        <div class="mb-4">
                            @if ($status_text == 'Completed')
                                <i class="fa fa-check-circle" style="font-size: 4rem;"></i>
                            @elseif($status_text == 'Failed')
                                <i class="fa fa-times-circle" style="font-size: 4rem;"></i>
                            @else
                                <i class="fa fa-exclamation-circle" style="font-size: 4rem;"></i>
                            @endif
                        </div>
                        <h1 class="display-5 mb-3">
                            {{ $status_text == 'Completed' ? 'Payment Successful' : ($status_text == 'Failed' ? 'Payment Failed' : 'Payment Status') }}
                        </h1>
                        <p class="lead mb-0">
                            {{ $status_text == 'Completed' ? 'Thank you! Your payment is complete.' : ($status_text == 'Failed' ? 'Unfortunately your transaction could not be completed.' : 'Please review the transaction details below.') }}
                        </p>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="p-3 rounded shadow-sm text-center bg-light">
                                    <h6 class="text-muted">Status</h6>
                                    <p
                                        class="mb-0 fw-bold text-{{ $status_text == 'Completed' ? 'success' : ($status_text == 'Failed' ? 'danger' : 'secondary') }}">
                                        {{ $status_text }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 rounded shadow-sm text-center bg-light">
                                    <h6 class="text-muted">Amount</h6>
                                    <p class="mb-0 fw-bold">{{ $amount ?? '-' }} {{ $currency ?? '' }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 rounded shadow-sm text-center bg-light">
                                    <h6 class="text-muted">Transaction ID</h6>
                                    <p class="mb-0 text-break">{{ $tran_id ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        @if (!empty($message))
                            <div class="alert alert-{{ $status_text == 'Completed' ? 'success' : ($status_text == 'Failed' ? 'danger' : 'info') }}"
                                role="alert">
                                {{ $message }}
                            </div>
                        @endif

                        <div class="d-flex flex-column flex-md-row justify-content-center gap-3 mt-4">
                            <a href="{{ url('my_business') }}" class="btn btn-success btn-lg px-4">Go to MyBusiness</a>
                            <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-lg px-4">Return Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
