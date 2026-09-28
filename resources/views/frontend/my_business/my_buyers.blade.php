@extends('layouts.frontend_layout')

@section('title')
    My Buyers - Business Dashboard
@endsection

@php
    $front = App\Models\FrontControl::first();
@endphp

@section('frontend_content')
    <section class="container py-5">
        <!-- Header -->
        <div class="row my-5">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="fw-bold mb-2" style="color: #333;">
                            <i class="fas fa-users text-success"></i> আমার ক্রেতারা
                        </h1>
                        <p class="text-muted">আপনার পণ্য কিনেছে এমন সকল ক্রেতাদের তালিকা</p>
                    </div>
                    <a href="{{ url('business_profile') }}" class="btn btn-outline-success">
                        <i class="fas fa-arrow-left"></i> পণ্যে ফিরুন
                    </a>
                </div>
            </div>
        </div>

        <!-- Alert Message -->
        @if ($message = Session::get('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Main Content -->
        <div class="row">
            <div class="col-lg-12">
                @if ($buyers->count() > 0)
                    <!-- Summary Cards -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm" style="border-left: 4px solid #81B622;">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2">মোট ক্রেতা</h6>
                                    <h3 class="fw-bold text-success">{{ $buyers->total() }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm" style="border-left: 4px solid #81B622;">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2">মোট বিক্রয়</h6>
                                    <h3 class="fw-bold text-success">৳{{ $buyers->sum('amount') }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm" style="border-left: 4px solid #81B622;">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2">মোট অর্ডার</h6>
                                    <h3 class="fw-bold text-success">{{ $buyers->sum('quantity') }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Buyers Table -->
                    <div class="card border-0 shadow-sm">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th>ক্রেতার নাম</th>
                                        <th>ইমেইল</th>
                                        <th>ফোন</th>
                                        <th>পণ্য</th>
                                        <th>অর্ডার</th>
                                        <th>পরিমাণ (৳)</th>
                                        <th>অবস্থা</th>
                                        <th>তারিখ</th>
                                        <th>অ্যাকশন</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($buyers as $buyer)
                                        <tr>
                                            <td>
                                                <strong>{{ $buyer->buyer_name }}</strong>
                                            </td>
                                            <td>
                                                <small>{{ $buyer->buyer_email }}</small>
                                            </td>
                                            <td>
                                                <small>{{ $buyer->buyer_phone }}</small>
                                            </td>
                                            <td>
                                                @if ($buyer->business)
                                                    <small class="badge bg-light text-dark">
                                                        {{ Str::limit($buyer->business->product_name, 25) }}
                                                    </small>
                                                @elseif ($buyer->product_name)
                                                    <small class="badge bg-light text-dark">
                                                        {{ Str::limit($buyer->product_name, 25) }}
                                                    </small>
                                                @else
                                                    <small class="badge bg-secondary">N/A</small>
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{ $buyer->quantity }} </strong>
                                            </td>
                                            <td>
                                                <strong class="text-success">৳{{ $buyer->amount }}</strong>
                                            </td>
                                            <td>
                                                @if ($buyer->payment_status === 'completed')
                                                    <span class="badge bg-success">সম্পূর্ণ</span>
                                                @elseif ($buyer->payment_status === 'pending')
                                                    <span class="badge bg-warning">অপেক্ষমাণ</span>
                                                @else
                                                    <span class="badge bg-danger">ব্যর্থ</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $buyer->created_at->format('d M Y H:i') }}
                                                </small>
                                            </td>
                                            <td>
                                                <a href="{{ url('buyer_details/' . $buyer->id) }}"
                                                    class="btn btn-sm btn-outline-success" title="বিস্তারিত দেখুন">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $buyers->links('pagination::bootstrap-4') }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="card border-0 shadow-sm text-center p-5">
                        <div class="mb-4">
                            <i class="fas fa-shopping-cart" style="font-size: 4rem; color: #ccc;"></i>
                        </div>
                        <h4 class="text-muted mb-3">এখনও কোনো ক্রেতা নেই</h4>
                        <p class="text-muted mb-4">যখন কেউ আপনার পণ্য কিনবে, তখন তারা এখানে দেখা যাবে।</p>
                        <a href="{{ url('business_profile') }}" class="btn btn-success">
                            <i class="fas fa-arrow-left"></i> পণ্যে ফিরুন
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <style>
        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }

        .badge {
            font-size: 0.8rem;
            padding: 0.4rem 0.6rem;
        }

        @media (max-width: 768px) {
            .table {
                font-size: 0.85rem;
            }

            th,
            td {
                padding: 0.5rem !important;
            }
        }
    </style>
@endsection
