@extends('layouts.frontend_layout')

@section('title')
    {{ $business->product_name }} - ক্রেতারা
@endsection

@php
    $front = App\Models\FrontControl::first();
@endphp

@section('frontend_content')
    <section class="container py-5 ">
        <!-- Header -->
        <div class="row mb-5">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h1 class="fw-bold" style="color: #333;">{{ $business->product_name }}</h1>
                        <p class="text-muted">এই পণ্যের সকল ক্রেতারা</p>
                    </div>
                    <a href="{{ url('my_buyers') }}" class="btn btn-outline-success">
                        <i class="fas fa-arrow-left"></i> সব ক্রেতারা দেখুন
                    </a>
                </div>
            </div>
        </div>

        <!-- Product Info Card -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="text-muted small">ক্যাটাগরি</label>
                                <p class="badge bg-light text-dark">{{ $business->category ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-3">
                                <label class="text-muted small">মূল্য প্রতি kg</label>
                                <p class="fw-bold">৳{{ $business->price }}</p>
                            </div>
                            <div class="col-md-3">
                                <label class="text-muted small">স্টক</label>
                                <p class="fw-bold">{{ $business->product_quantity }} kg</p>
                            </div>
                            <div class="col-md-3">
                                <label class="text-muted small">মোট অর্ডার</label>
                                <p class="fw-bold text-success">{{ $buyers->total() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <div class="col-lg-12">
                @if ($buyers->count() > 0)
                    <!-- Summary Cards -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm" style="border-left: 4px solid #81B622;">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2">মোট বিক্রয় (৳)</h6>
                                    <h3 class="fw-bold text-success">৳{{ $buyers->sum('amount') }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm" style="border-left: 4px solid #81B622;">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2">মোট পরিমাণ (kg)</h6>
                                    <h3 class="fw-bold text-success">{{ $buyers->sum('quantity') }} kg</h3>
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
                                        <th>পরিমাণ</th>
                                        <th>মূল্য (৳)</th>
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
                                                <small>
                                                    <a
                                                        href="mailto:{{ $buyer->buyer_email }}">{{ $buyer->buyer_email }}</a>
                                                </small>
                                            </td>
                                            <td>
                                                <small>
                                                    <a href="tel:{{ $buyer->buyer_phone }}">{{ $buyer->buyer_phone }}</a>
                                                </small>
                                            </td>
                                            <td>
                                                <strong>{{ $buyer->quantity }} kg</strong>
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
                                                    {{ $buyer->created_at->format('d M Y') }}
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
                        <h4 class="text-muted mb-3">এখনও এই পণ্য কেউ কেনে নি</h4>
                        <p class="text-muted mb-4">যখন কেউ এই পণ্য কিনবে, তখন তারা এখানে দেখা যাবে।</p>
                        <a href="{{ url('my_buyers') }}" class="btn btn-success">
                            <i class="fas fa-arrow-left"></i> সব ক্রেতারা দেখুন
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

        a {
            color: #81B622;
        }

        a:hover {
            color: #6fa01a;
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
