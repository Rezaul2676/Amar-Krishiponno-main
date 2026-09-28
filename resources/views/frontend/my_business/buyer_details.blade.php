@extends('layouts.frontend_layout')

@section('title')
    ক্রেতার বিবরণ
@endsection

@php
    $front = App\Models\FrontControl::first();
@endphp

@section('frontend_content')
    <section class="container py-5 my-5">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="fw-bold" style="color: #333;">ক্রেতার বিবরণ</h1>
                    <a href="{{ url('my_buyers') }}" class="btn btn-outline-success">
                        <i class="fas fa-arrow-left"></i> ফিরে যান
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row">
            <!-- Buyer Info Card -->
            <div class="col-lg-8">
                <!-- Personal Information -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header" style="background-color: #81B622; color: white;">
                        <h5 class="mb-0"><i class="fas fa-user-circle"></i> ব্যক্তিগত তথ্য</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">নাম</label>
                                <p class="fw-bold">{{ $buyer->buyer_name }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">ইমেইল</label>
                                <p>
                                    <a href="mailto:{{ $buyer->buyer_email }}">{{ $buyer->buyer_email }}</a>
                                </p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">ফোন</label>
                                <p>
                                    <a href="tel:{{ $buyer->buyer_phone }}">{{ $buyer->buyer_phone }}</a>
                                </p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">পোস্টাল কোড</label>
                                <p class="fw-bold">{{ $buyer->buyer_post_code }}</p>
                            </div>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <label class="text-muted small">ঠিকানা</label>
                            <p>{{ $buyer->buyer_address }}</p>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">জেলা</label>
                                <p>{{ $buyer->buyer_state }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Purchase Information -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header" style="background-color: #81B622; color: white;">
                        <h5 class="mb-0"><i class="fas fa-shopping-bag"></i> ক্রয়ের তথ্য</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">পণ্য নাম</label>
                                @if ($buyer->business)
                                    <p class="fw-bold">{{ $buyer->business->product_name }}</p>
                                @elseif ($buyer->product_name)
                                    <p class="fw-bold">{{ $buyer->product_name }}</p>
                                @else
                                    <p class="text-muted">পণ্য পাওয়া যায়নি</p>
                                @endif
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">পরিমাণ</label>
                                <p class="fw-bold">{{ $buyer->quantity }} kg</p>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">মূল্য (৳)</label>
                                <p class="fw-bold text-success" style="font-size: 1.3rem;">৳{{ $buyer->amount }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">পেমেন্ট স্থিতি</label>
                                <p>
                                    @if ($buyer->payment_status === 'completed')
                                        <span class="badge bg-success">সম্পূর্ণ</span>
                                    @elseif ($buyer->payment_status === 'pending')
                                        <span class="badge bg-warning">অপেক্ষমাণ</span>
                                    @else
                                        <span class="badge bg-danger">ব্যর্থ</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">লেনদেন আইডি</label>
                                <p class="small"><code>{{ $buyer->transaction_id }}</code></p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">ক্রয়ের তারিখ</label>
                                <p>{{ $buyer->created_at->format('d M Y, h:i A') }}</p>
                            </div>
                        </div>

                        @if ($buyer->payment_status === 'pending')
                            <form action="{{ url('seller_approve_buyer/' . $buyer->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success mb-3">
                                    <i class="fas fa-check-circle"></i> Order Approve করুন
                                </button>
                            </form>
                        @endif

                        @if ($buyer->notes)
                            <hr>
                            <div class="mb-3">
                                <label class="text-muted small">মন্তব্য</label>
                                <p>{{ $buyer->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Product Details -->
                @if ($buyer->business)
                    <div class="card border-0 shadow-sm">
                        <div class="card-header" style="background-color: #81B622; color: white;">
                            <h5 class="mb-0"><i class="fas fa-boxes"></i> পণ্যের বিবরণ</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="text-muted small">ক্যাটাগরি</label>
                                    <p class="badge bg-light text-dark">{{ $buyer->business->category ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="text-muted small">মূল্য প্রতি kg</label>
                                    <p class="fw-bold">৳{{ $buyer->business->price }}</p>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="text-muted small">স্টক</label>
                                    <p class="fw-bold">{{ $buyer->business->product_quantity }} kg</p>
                                </div>
                            </div>

                            <hr>

                            <div class="mb-3">
                                <label class="text-muted small">বিবরণ</label>
                                <p>{{ $buyer->business->product_description }}</p>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ url('business_product_details/' . $buyer->business->id) }}"
                                    class="btn btn-sm btn-success">
                                    <i class="fas fa-eye"></i> পণ্য দেখুন
                                </a>
                                <a href="{{ url('buyers_by_product/' . $buyer->business->id) }}"
                                    class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-users"></i> এই পণ্যের অন্যান্য ক্রেতারা
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Quick Summary -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h6 class="text-muted mb-3">দ্রুত সংক্ষিপ্তসার</h6>
                        <div class="mb-3">
                            <small class="text-muted">ক্রয়ের মূল্য</small>
                            <h4 class="text-success fw-bold">৳{{ $buyer->amount }}</h4>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">পরিমাণ</small>
                            <h4 class="fw-bold">{{ $buyer->quantity }} kg</h4>
                        </div>
                        <div>
                            <small class="text-muted">প্রতি kg</small>
                            <h4 class="fw-bold">
                                ৳{{ $buyer->quantity > 0 ? round($buyer->amount / $buyer->quantity, 2) : 0 }}
                            </h4>
                        </div>
                    </div>
                </div>

                <!-- Contact Actions -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <h6 class="text-muted mb-3">যোগাযোগ করুন</h6>
                        <a href="mailto:{{ $buyer->buyer_email }}" class="btn btn-outline-success w-100 mb-2">
                            <i class="fas fa-envelope"></i> ইমেইল পাঠান
                        </a>
                        <a href="tel:{{ $buyer->buyer_phone }}" class="btn btn-outline-success w-100 mb-2">
                            <i class="fas fa-phone"></i> ফোন করুন
                        </a>
                    </div>
                </div>

                <!-- Status Card -->
                <div class="card border-0 shadow-sm" style="border-left: 4px solid #81B622;">
                    <div class="card-body">
                        <h6 class="text-muted mb-3">লেনদেনের অবস্থা</h6>
                        <p>
                            @if ($buyer->payment_status === 'completed')
                                <span class="badge bg-success" style="font-size: 0.9rem;">
                                    <i class="fas fa-check-circle"></i> সম্পূর্ণভাবে পেমেন্ট করা হয়েছে
                                </span>
                            @elseif ($buyer->payment_status === 'pending')
                                <span class="badge bg-warning" style="font-size: 0.9rem;">
                                    <i class="fas fa-clock"></i> অপেক্ষমাণ
                                </span>
                            @else
                                <span class="badge bg-danger" style="font-size: 0.9rem;">
                                    <i class="fas fa-times-circle"></i> ব্যর্থ
                                </span>
                            @endif
                        </p>
                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-calendar-alt"></i> {{ $buyer->created_at->format('d M Y') }}
                        </small>
                    </div>
                </div>

                @if(isset($fraudResult))
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h6 class="text-muted mb-3">Fraud Risk</h6>
                            @php
                                $fraudPercent = $fraudResult['score'] ?? 0;
                                $fraudLabel = 'Low';
                                $fraudClass = 'badge-success';
                                if ($fraudPercent >= 60) {
                                    $fraudLabel = 'High';
                                    $fraudClass = 'badge-danger';
                                } elseif ($fraudPercent >= 30) {
                                    $fraudLabel = 'Medium';
                                    $fraudClass = 'badge-warning';
                                }
                            @endphp
                            <div class="mb-2">
                                <span class="badge {{ $fraudClass }}">{{ $fraudPercent }}% ({{ $fraudLabel }})</span>
                            </div>
                            @if(!empty($fraudResult['reasons']))
                                <small class="text-muted d-block mt-2">Reasons:</small>
                                <ul class="small text-muted">
                                    @foreach($fraudResult['reasons'] as $reason)
                                        <li>{{ $reason }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <style>
        code {
            background-color: #f5f5f5;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.85rem;
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
        }

        a {
            color: #81B622;
        }

        a:hover {
            color: #6fa01a;
        }
    </style>
@endsection
