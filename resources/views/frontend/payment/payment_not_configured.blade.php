@extends('layouts.frontend_layout')

@section('title')
    AgroBd - Configure Payment Settings
@endsection

@section('frontend_content')
    <section class="container mt-5 mb-5 pt-3">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">

                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="fas fa-exclamation-circle" style="font-size: 60px; color: #ff9800;"></i>
                            <h2 class="mt-3">Payment Settings Not Configured</h2>
                            <p class="text-muted">The seller of this product has not configured their payment method yet</p>
                        </div>

                        <hr>

                        <div class="alert alert-warning border-0" style="background: #fff3cd;">
                            <h5 class="mb-3"><i class="fas fa-info-circle"></i> What Does This Mean?</h5>
                            <p>
                                This seller needs to set up a payment method (SSLCommerz, bKash, or Bank Transfer) before
                                you can purchase their products.
                            </p>
                        </div>

                        <hr>

                        <div class="alert alert-info border-0" style="background: #d1ecf1;">
                            <h5 class="mb-3"><i class="fas fa-cog"></i> How Can You Help?</h5>
                            <p class="mb-0">
                                Please ask the seller to:
                            </p>
                            <ol class="mt-2 mb-0">
                                <li>Go to their <strong>Business Profile</strong></li>
                                <li>Click <strong>Edit</strong> on their product</li>
                                <li>Scroll down to <strong>Payment Settings</strong> section</li>
                                <li>Select a payment gateway (SSLCommerz, bKash, or Bank Transfer)</li>
                                <li>Enter their payment credentials:
                                    <ul>
                                        <li><strong>For SSLCommerz:</strong> Store ID and Store Password</li>
                                        <li><strong>For bKash:</strong> Their bKash number</li>
                                        <li><strong>For Bank Transfer:</strong> Bank details</li>
                                    </ul>
                                </li>
                                <li>Click <strong>Update</strong> to save</li>
                            </ol>
                        </div>

                        <hr>

                        <div class="d-flex gap-2 justify-content-between">
                            <a href="{{ url('/') }}" class="btn btn-secondary">
                                <i class="fas fa-home"></i> Back to Home
                            </a>
                            <a href="{{ url('/business_profile') }}" class="btn btn-primary">
                                <i class="fas fa-store"></i> Browse Other Sellers
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
