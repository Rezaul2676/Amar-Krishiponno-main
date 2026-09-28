@extends('layouts.frontend_layout')

@section('title')
    AgroBd - My Business
@endsection

@php
    $front = App\Models\FrontControl::first();
@endphp

@section('frontend_content')
    <style>
        .hero-banner {
            position: relative;
            min-height: 60vh;
            background-image: url({{ asset('img_DB/front/shop_banner/' . $front->shop_banner_img) }});
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            overflow: hidden;
        }

        .hero-banner::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.55) 0%, rgba(3, 102, 51, 0.6) 100%);
            z-index: 1;
        }

        .hero-banner-content {
            position: relative;
            z-index: 2;
            animation: fadeInUp 0.8s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .hero-title {
            font-size: 3.8rem;
            font-weight: 900;
            color: white;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.5), 1px 1px 2px rgba(0, 0, 0, 0.3);
            margin-bottom: 20px;
            letter-spacing: -0.5px;
        }

        .hero-subtitle {
            font-size: 1.4rem;
            color: rgba(255, 255, 255, 1);
            max-width: 700px;
            line-height: 1.9;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
            font-weight: 500;
        }

        .search-section {
            background: linear-gradient(to bottom, #f8f9fa, white);
            padding: 60px 0;
            margin-top: -40px;
            position: relative;
            z-index: 3;
        }

        .search-form-wrapper {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 25px;
            transition: all 0.3s ease;
        }

        .search-form-wrapper:hover {
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
            transform: translateY(-5px);
        }

        .search-input {
            border: none;
            padding: 12px 18px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .search-input::placeholder {
            color: #adb5bd;
        }

        .search-input:focus {
            outline: none;
            background-color: #f0f8f5;
        }

        .business-card {
            height: 100%;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            background: white;
        }

        .business-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        }

        .business-card-image-wrapper {
            position: relative;
            height: 280px;
            overflow: hidden;
            background: #f0f0f0;
        }

        .business-card-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .business-card:hover .business-card-image {
            transform: scale(1.08);
        }

        .card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 40%, rgba(0, 0, 0, 0.3) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .business-card:hover .card-overlay {
            opacity: 1;
        }

        .category-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3);
            z-index: 2;
        }

        .card-body {
            padding: 24px;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 12px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .card-description {
            color: #6c757d;
            font-size: 0.95rem;
            min-height: 48px;
            line-height: 1.5;
            margin-bottom: 18px;
        }

        .price-stock-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
            padding: 12px 0;
            border-top: 1px solid #e9ecef;
            border-bottom: 1px solid #e9ecef;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: 800;
            color: #28a745;
        }

        .stock-info {
            background: #f0f8f5;
            color: #2d7a4a;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .seller-district-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
            font-size: 0.9rem;
        }

        .seller-name {
            color: #495057;
            font-weight: 500;
        }

        .district-badge {
            background: linear-gradient(135deg, #6c757d, #495057);
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
        }

        .card-footer-btn {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
        }

        .card-footer-btn:hover {
            background: linear-gradient(135deg, #20c997, #17a2b8);
            transform: translateX(5px);
            color: white;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: #1a1a1a;
            margin-bottom: 15px;
            position: relative;
            padding-bottom: 15px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 5px;
            background: linear-gradient(90deg, #28a745, #20c997);
            border-radius: 3px;
        }

        .section-subtitle {
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 30px;
        }

        .products-grid {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            flex-wrap: nowrap;
            align-items: center;
        }

        .action-buttons .btn {
            padding: 12px 28px !important;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1rem;
            transition: all 0.3s ease;
            border: 2px solid white;
            white-space: nowrap;
            flex-shrink: 0;
            letter-spacing: 0.3px;
        }

        .action-buttons .btn-success {
            background: white;
            color: #28a745;
            border-color: white;
        }

        .action-buttons .btn-success:hover {
            background: #f0f0f0;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .action-buttons .btn-outline-light {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border-color: white;
            font-weight: 700;
        }

        .action-buttons .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.35);
            border-color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
                font-weight: 900;
            }

            .hero-subtitle {
                font-size: 1.1rem;
            }

            .action-buttons {
                flex-wrap: wrap;
                gap: 10px;
            }

            .action-buttons .btn {
                padding: 10px 20px !important;
                font-size: 0.9rem;
                flex-shrink: 1;
            }
        }

        @media (max-width: 576px) {
            .hero-title {
                font-size: 2rem;
                margin-bottom: 15px;
            }

            .hero-subtitle {
                font-size: 0.95rem;
                margin-bottom: 20px;
            }

            .action-buttons {
                flex-wrap: wrap;
                gap: 8px;
            }

            .action-buttons .btn {
                padding: 8px 16px !important;
                font-size: 0.8rem;
                flex-shrink: 1;
            }
        }

        .pagination {
            justify-content: center;
            margin-top: 50px;
        }

        .no-results-message {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
    </style>

    <!-- Hero Banner Section -->
    <section class="hero-banner mt-5">
        <div class="container h-100 d-flex flex-column justify-content-center hero-banner-content mt-5">
            <h1 class="hero-title mt-5">বাংলাদেশি কৃষি পণ্য বাজার</h1>
            <p class="hero-subtitle">সরাসরি কৃষক ও ক্ষুদ্র ব্যবসায়ীর কাছ থেকে শুদ্ধ, তাজা ও মানসম্মত agro product কিনুন।</p>
            <div class="action-buttons">
                <a href="{{ url('add_business') }}" class="btn btn-success">+ পণ্য যোগ করুন</a>
                <a href="{{ url('business_profile') }}" class="btn btn-outline-light">👤 আমার ব্যবসা</a>
            </div>
        </div>
    </section>

    <!-- Search & Filter Section -->
    <section class="search-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="row align-items-end mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <h2 class="section-title">AgroBd ব্যবসা সম্ভার</h2>
                            <p class="section-subtitle">সার্ভিস ও পণ্যে নির্ভরযোগ্যতা, স্বচ্ছতা এবং ফার্ম-টু-টেবিল মানদন্ড।
                            </p>
                        </div>
                    </div>
                    <form action="{{ url('search_business_query') }}" method="GET" class="search-form-wrapper">
                        {{ csrf_field() }}
                        <div class="input-group">
                            <input type="text" name="query" class="form-control search-input"
                                placeholder="🔍 কোন পণ্য খুঁজছেন?" aria-label="Search business" required>
                            <button type="submit" class="btn btn-success card-footer-btn ms-2">খুঁজুন</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Top Rated Business Section -->
    @if(isset($topRatedBusiness) && $topRatedBusiness->count() > 0)
        <section class="container py-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="section-title">সেরা রেটিং পণ্যসমূহ</h2>
                    <p class="section-subtitle">ব্যবসায়ীদের মধ্যে সর্বোচ্চ রেটিং পাওয়া পণ্যগুলো এখানে দেখুন।</p>
                </div>
            </div>
            <div class="row g-4 products-grid">
                @foreach ($topRatedBusiness as $item)
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ url('business_product_details/' . $item->id) }}" class="text-decoration-none text-dark">
                            <div class="business-card">
                                <div class="business-card-image-wrapper">
                                    <img src="{{ asset('img_DB/my_business/image_one/' . $item->image_one) }}"
                                        class="business-card-image" alt="{{ $item->product_name }}">
                                    <div class="card-overlay"></div>
                                    <span class="category-badge">Top Rated</span>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->product_name }}</h5>
                                    <p class="card-description">{{ \Illuminate\Support\Str::limit($item->product_description, 70) }}</p>
                                    <div class="price-stock-row">
                                        <strong class="product-price">৳{{ $item->price }}</strong>
                                        <span class="stock-info">📦 {{ $item->product_quantity }} kg</span>
                                    </div>
                                    <div class="seller-district-row">
                                        <span class="seller-name">📍 {{ \Illuminate\Support\Str::limit($item->name, 18) }}</span>
                                        <span class="district-badge">{{ $item->district ?? 'Bangladesh' }}</span>
                                    </div>
                                    <div class="mb-3">
                                        <span class="text-success">{{ number_format($item->ratings_avg_stars_rated ?? 0, 1) }} ⭐</span>
                                        <span class="text-muted">({{ $item->ratings_count ?? 0 }} রেট)</span>
                                    </div>
                                    <button class="card-footer-btn">বিস্তারিত দেখুন →</button>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Products Grid Section -->
    <section class="container py-5">
        @if ($business->count() > 0)
            <div class="row g-4 products-grid">
                @foreach ($business as $item)
                    <div class="col-lg-4 col-md-6">
                        <a href="{{ url('business_product_details/' . $item->id) }}" class="text-decoration-none text-dark">
                            <div class="business-card">
                                <!-- Card Image with Overlay -->
                                <div class="business-card-image-wrapper">
                                    <img src="{{ asset('img_DB/my_business/image_one/' . $item->image_one) }}"
                                        class="business-card-image" alt="{{ $item->product_name }}">
                                    <div class="card-overlay"></div>
                                    <span class="category-badge">{{ $item->category ?? 'Agro' }}</span>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->product_name }}</h5>
                                    <p class="card-description">
                                        {{ \Illuminate\Support\Str::limit($item->product_description, 70) }}</p>

                                    <!-- Price & Stock -->
                                    <div class="price-stock-row">
                                        <strong class="product-price">৳{{ $item->price }}</strong>
                                        <span class="stock-info">📦 {{ $item->product_quantity }} kg</span>
                                    </div>

                                    <!-- Seller & District -->
                                    <div class="seller-district-row">
                                        <span class="seller-name">📍
                                            {{ \Illuminate\Support\Str::limit($item->name, 18) }}</span>
                                        <span class="district-badge">{{ $item->district ?? 'Bangladesh' }}</span>
                                    </div>

                                    <!-- CTA Button -->
                                    <button class="card-footer-btn">বিস্তারিত দেখুন →</button>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                {{ $business->links() }}
            </div>
        @else
            <div class="no-results-message">
                <h3>কোনো পণ্য পাওয়া যায়নি</h3>
                <p>এখনই নতুন পণ্য যোগ করুন এবং আপনার ব্যবসা শুরু করুন।</p>
                <a href="{{ url('add_business') }}" class="btn btn-success btn-lg mt-3">+ আপনার পণ্য যোগ করুন</a>
            </div>
        @endif
    </section>
@endsection
