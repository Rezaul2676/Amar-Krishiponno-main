@extends('layouts.frontend_layout')


@section('title')
    AgroBd - Business Profile
@endsection

@php
    $front = App\Models\FrontControl::first();
@endphp

@section('frontend_content')
    <section class="container featured mt-5 pb-5 pt-3">

        <!-- Header Section with Title and Add Button -->
        <div class="d-flex justify-content-between align-items-center mb-4 pt-4 mt-5">
            <div>
                <h2 class="font-weight-bold mb-0">আমার ব্যবসা</h2>
                <hr class="mt-2 mb-0" style="width: 100px;">
            </div>
            <div class="d-flex gap-2">
                <a class="btn btn-sm" style="background:#81B622; color:white;" href="{{ url('my_buyers') }}" role="button">
                    <i class="fas fa-users"></i> আমার ক্রেতারা
                </a>
                <a class="btn btn-sm" style="background:#81B622; color:white;" href="{{ url('add_business') }}"
                    role="button">
                    <i class="fas fa-plus"></i> + পণ্য যোগ করুন
                </a>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="mt-5">
            @if ($business->count() > 0)
                <div class="row g-3">
                    @foreach ($business as $item)
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="product-card-modern">
                                <!-- Product Image -->
                                <div class="product-image-section">
                                    <a href="{{ url('profile_business_product_details/' . $item->id) }}" class="image-link">
                                        <img src="{{ asset('img_DB/my_business/image_one/' . $item->image_one) }}"
                                            alt="{{ $item->product_name }}" class="product-img">
                                        <div class="stock-badge">
                                            @if ($item->product_quantity > 0)
                                                <span class="badge-stock">KG: {{ $item->product_quantity }}</span>
                                            @else
                                                <span class="badge-stock out-of-stock">স্টক শেষ</span>
                                            @endif
                                        </div>
                                    </a>
                                </div>

                                <!-- Product Info -->
                                <div class="product-info-section">
                                    <h4 class="product-title">
                                        <a href="{{ url('profile_business_product_details/' . $item->id) }}">
                                            {{ $item->product_name }}
                                        </a>
                                    </h4>

                                    <p class="product-description">
                                        {{ Str::limit($item->product_description, 80) }}
                                    </p>

                                    <!-- Price and Details Row -->
                                    <div class="price-detail-row">
                                        <div class="price-section">
                                            <span class="price">৳{{ $item->price }}</span>
                                        </div>
                                        <div class="detail-badges">
                                            <span class="detail-badge">KG: {{ $item->product_quantity }}</span>
                                        </div>
                                    </div>

                                    <!-- Seller Info -->
                                    <div class="seller-info">
                                        <span class="seller-label">বিক্রেতা:</span>
                                        <span class="seller-name">{{ Auth::user()->name ?? 'Admin' }}</span>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <a href="{{ url('profile_business_product_details/' . $item->id) }}"
                                    class="btn-action-primary">
                                    বিস্তারিত দেখুন →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info text-center" role="alert">
                    <h5>কোনো ব্যবসা যোগ করা হয়নি</h5>
                    <p>আপনি এখনও কোনো ব্যবসায়িক প্রোফাইল যোগ করেননি।</p>
                    <a class="btn btn-sm" style="background:#81B622; color:white;" href="{{ url('add_business') }}"
                        role="button">
                        <i class="fas fa-plus"></i> প্রথম ব্যবসা তৈরি করুন
                    </a>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if ($business->hasPages())
            <div class="d-flex justify-content-center mt-5 mb-5">
                {{ $business->links() }}
            </div>
        @endif
    </section>

    <style>
        /* Modern Product Card Styles */
        .product-card-modern {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .product-card-modern:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            transform: translateY(-4px);
        }

        /* Product Image Section */
        .product-image-section {
            position: relative;
            overflow: hidden;
            background-color: #f5f5f5;
            height: 200px;
        }

        .image-link {
            display: block;
            width: 100%;
            height: 100%;
        }

        .product-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-card-modern:hover .product-img {
            transform: scale(1.05);
        }

        /* Stock Badge */
        .stock-badge {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .badge-stock {
            display: inline-block;
            background-color: rgba(129, 182, 34, 0.9);
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-stock.out-of-stock {
            background-color: rgba(220, 53, 69, 0.9);
        }

        /* Product Info Section */
        .product-info-section {
            padding: 15px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .product-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
            line-height: 1.4;
            max-height: 2.8em;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .product-title a {
            text-decoration: none;
            color: #333;
        }

        .product-title a:hover {
            color: #81B622;
        }

        .product-description {
            font-size: 0.85rem;
            color: #666;
            line-height: 1.4;
            margin-bottom: 12px;
            flex-grow: 1;
        }

        /* Price and Detail Row */
        .price-detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .price-section {
            display: flex;
            align-items: center;
        }

        .price {
            font-size: 1.3rem;
            font-weight: 700;
            color: #81B622;
        }

        .detail-badges {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .detail-badge {
            display: inline-block;
            background-color: #f0f0f0;
            color: #666;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* Seller Info */
        .seller-info {
            font-size: 0.85rem;
            color: #999;
            margin-bottom: 12px;
        }

        .seller-label {
            font-weight: 600;
            color: #666;
        }

        .seller-name {
            color: #81B622;
            font-weight: 600;
        }

        /* Action Button */
        .btn-action-primary {
            display: block;
            background-color: #81B622;
            color: white;
            text-align: center;
            padding: 12px 16px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            border: none;
            border-radius: 0 0 12px 12px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-action-primary:hover {
            background-color: #6fa01a;
            text-decoration: none;
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .product-info-section {
                padding: 12px;
            }

            .product-title {
                font-size: 1rem;
            }

            .price {
                font-size: 1.2rem;
            }

            .price-detail-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 6px;
            }

            .detail-badges {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .product-image-section {
                height: 150px;
            }

            .product-info-section {
                padding: 10px;
            }

            .product-title {
                font-size: 0.95rem;
            }

            .product-description {
                font-size: 0.8rem;
            }

            .price {
                font-size: 1.1rem;
            }

            .seller-info {
                font-size: 0.8rem;
            }
        }
    </style>

@endsection
