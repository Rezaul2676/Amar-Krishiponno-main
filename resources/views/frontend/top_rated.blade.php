@extends('layouts.frontend_layout')

@section('title')
    AgroBd - Top Rated Products
@endsection

@php
    $front = App\Models\FrontControl::first();
    $categories = App\Models\Category::where('status', 1)->get();
@endphp

@section('frontend_content')

    <section class="bg-light py-5">
        <div class="container">
            <div class="py-5">
                <h2 class="shop-section-title"><strong>সেরা রেটিং পণ্যসমূহ</strong></h2>
                <p class="shop-section-subtitle">গড় রেটিং অনুসারে সাজানো জনপ্রিয় ও মানসম্মত পণ্যসমূহ</p>
            </div>

            <div class="row g-4">
                @forelse ($topRatedBusinesses as $product)
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ url('business_product_details/' . $product->id) }}" class="text-decoration-none text-dark">
                            <div class="admin-product-card">
                                <div class="admin-product-image-wrapper">
                                    <img src="{{ asset('img_DB/my_business/image_one/' . $product->image_one) }}"
                                        class="admin-product-image" alt="{{ $product->product_name }}">
                                    <div class="admin-card-overlay"></div>
                                    <span class="admin-product-badge">Top Rated</span>
                                </div>

                                <div style="padding: 20px;">
                                    <h5 class="admin-product-title">{{ $product->product_name }}</h5>
                                    <p class="admin-product-desc">
                                        {{ \Illuminate\Support\Str::limit($product->product_description ?? '', 70) }}</p>

                                    <div class="admin-rating-row mb-3">
                                        <span class="text-success">{{ number_format($product->ratings_avg_stars_rated ?? 0, 1) }} ⭐</span>
                                        <span class="text-muted">({{ $product->ratings_count ?? 0 }} রেট)</span>
                                    </div>

                                    <div class="admin-price-stock">
                                        <strong class="admin-product-price">৳{{ $product->price }}</strong>
                                        <span class="admin-stock-badge">📦 Stock: {{ $product->product_quantity }} kg</span>
                                    </div>

                                    <div class="admin-location-admin-row">
                                        <span class="admin-location-text">📍 {{ $product->district ?? 'Bangladesh' }}</span>
                                        <span class="admin-seller-badge">{{ \Illuminate\Support\Str::limit($product->name ?? 'Seller', 12) }}</span>
                                    </div>

                                    <button class="admin-details-btn">বিস্তারিত দেখুন →</button>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">কোনো রেট করা ব্যবসা/পণ্য পাওয়া যায়নি।</div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="bg-light py-5">
        <div class="container">
            <div class="py-5">
                <h2 class="shop-section-title"><strong>সেরা রেটিং শপ পণ্যসমূহ</strong></h2>
                <p class="shop-section-subtitle">গড় রেটিং অনুসারে সাজানো জনপ্রিয় ও মানসম্মত শপ পণ্যসমূহ</p>
            </div>

            <div class="row g-4">
                @forelse ($topRatedProducts as $product)
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ url('product_details/' . $product->id) }}" class="text-decoration-none text-dark">
                            <div class="admin-product-card">
                                <div class="admin-product-image-wrapper">
                                    <img src="{{ asset('img_DB/product/image_one/' . $product->image_one) }}"
                                        class="admin-product-image" alt="{{ $product->product_name }}">
                                    <div class="admin-card-overlay"></div>
                                    <span class="admin-product-badge">Top Rated</span>
                                </div>

                                <div style="padding: 20px;">
                                    <h5 class="admin-product-title">{{ $product->product_name }}</h5>
                                    <p class="admin-product-desc">
                                        {{ \Illuminate\Support\Str::limit($product->description ?? '', 70) }}</p>

                                    <div class="admin-rating-row mb-3">
                                        <span class="text-success">{{ number_format($product->ratings_avg_stars_rated ?? 0, 1) }} ⭐</span>
                                        <span class="text-muted">({{ $product->ratings_count ?? 0 }} রেট)</span>
                                    </div>

                                    <div class="admin-price-stock">
                                        <strong class="admin-product-price">৳{{ $product->price }}</strong>
                                        <span class="admin-stock-badge">📦 Stock: {{ $product->product_quantity }} kg</span>
                                    </div>

                                    <div class="admin-location-admin-row">
                                        <span class="admin-location-text">📍 Dhaka</span>
                                        <span class="admin-seller-badge">Admin</span>
                                    </div>

                                    <button class="admin-details-btn">বিস্তারিত দেখুন →</button>
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">কোনো শপের রেট করা পণ্য পাওয়া যায়নি।</div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="container py-5">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="p-4 rounded-4 shadow-sm h-100" style="background: #f7fded;">
                    <h4 class="fw-bold">সরাসরি কৃষকদের কাছ থেকে</h4>
                    <p class="text-muted">Amar-Krishiponno-এ আপনি সরাসরি কৃষক ও ক্ষুদ্র ব্যবসায়ীর কাছ থেকে পণ্য নিতে পারবেন।</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="p-4 rounded-4 shadow-sm h-100" style="background: #fff8e6;">
                    <h4 class="fw-bold">বিক্রেতার বিশ্বাস</h4>
                    <p class="text-muted">সাবেক ভোক্তা ও বিক্রেতার উপর ভিত্তি করে নিরাপদ লেনদেন নিশ্চিত করি।</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="p-4 rounded-4 shadow-sm h-100" style="background: #e8f7ff;">
                    <h4 class="fw-bold">সহজ অর্ডার</h4>
                    <p class="text-muted">পণ্য খুঁজুন, তুলুন, এবং মাত্র কয়েক ক্লিকেই অর্ডার করুন।</p>
                </div>
            </div>
        </div>
    </section>

    <style>
        .admin-product-card {
            height: 100%;
            border: none;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            background: white;
        }

        .admin-product-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        }

        .admin-product-image-wrapper {
            position: relative;
            height: 260px;
            overflow: hidden;
            background: #f0f0f0;
        }

        .admin-product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .admin-product-card:hover .admin-product-image {
            transform: scale(1.1);
        }

        .admin-card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 40%, rgba(0, 0, 0, 0.25) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .admin-product-card:hover .admin-card-overlay {
            opacity: 1;
        }

        .admin-product-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: linear-gradient(135deg, #ff6b6b, #ff8787);
            color: white;
            padding: 6px 14px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.8rem;
            box-shadow: 0 3px 8px rgba(255, 107, 107, 0.3);
            z-index: 2;
        }

        .admin-product-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 10px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .admin-product-desc {
            color: #6c757d;
            font-size: 0.9rem;
            min-height: 45px;
            line-height: 1.5;
            margin-bottom: 15px;
        }

        .admin-rating-row {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            font-size: 0.95rem;
            color: #495057;
        }

        .admin-price-stock {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-top: 1px solid #e9ecef;
            border-bottom: 1px solid #e9ecef;
            margin-bottom: 15px;
        }

        .admin-product-price {
            font-size: 1.4rem;
            font-weight: 800;
            color: #28a745;
        }

        .admin-stock-badge {
            background: #e8f5e9;
            color: #2d7a4a;
            padding: 6px 11px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .admin-location-admin-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            font-size: 0.85rem;
        }

        .admin-location-text {
            color: #495057;
            font-weight: 500;
        }

        .admin-seller-badge {
            background: #f5f5f5;
            color: #495057;
            padding: 6px 12px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.85rem;
        }

        .admin-details-btn {
            width: 100%;
            padding: 12px 18px;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            background: #28a745;
            color: white;
            transition: all 0.3s ease;
        }

        .admin-details-btn:hover {
            background: #20c997;
            transform: translateY(-2px);
        }

        .shop-section-title {
            font-size: 2.3rem;
            font-weight: 800;
            color: #1a1a1a;
            margin-bottom: 10px;
        }

        .shop-section-subtitle {
            color: #6c757d;
            margin-bottom: 0;
        }
    </style>
@endsection
