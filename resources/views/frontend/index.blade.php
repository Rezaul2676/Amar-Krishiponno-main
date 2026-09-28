@extends('layouts.frontend_layout')


@section('title')
    AgroBd - Home
@endsection

@php
    $front = App\Models\FrontControl::first();
@endphp

@section('frontend_content')
    <section id="home"
        style="background-image: url({{ asset('img_DB/front/home/' . $front->home_bg_img) }}); background-size: cover; background-position: center; min-height: 90vh; display: flex; align-items: center;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 text-white">
                    <div style="max-width: 700px; background: rgba(0,0,0,0.45); padding: 40px; border-radius: 16px;">
                        <h5 class="mb-3" style="letter-spacing: 1px; color: #f8f7f2;">{{ $front->home_bg_txt1 }}</h5>
                        <h1 class="display-4 fw-bold mb-4" style="color: #fff; line-height: 1.1;">
                            <span>{{ $front->home_bg_txt2 }}</span>
                        </h1>
                        <p class="lead text-light mb-4" style="font-size: 1.1rem;">{{ $front->home_bg_txt3 }}</p>
                        <div class="d-flex gap-3 flex-wrap">
                            <a class="btn btn-success btn-lg px-4" href="{{ url('my_business') }}">পণ্যসমূহ দেখুন</a>
                            <a class="btn btn-outline-light btn-lg px-4" href="{{ url('contact') }}">যোগাযোগ করুন</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block">
                    <div
                        style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); border-radius: 24px; padding: 30px; backdrop-filter: blur(8px);">
                        <h4 class="text-white mb-4">কেন Amar-Krishiponno?</h4>
                        <div class="mb-3">
                            <h6 class="text-white mb-1">বাংলাদেশি কৃষি বাজার</h6>
                            <p class="text-light" style="font-size: 0.95rem;">স্থানীয় কৃষকের সরাসরি পণ্য, সাশ্রয়ী দাম ও
                                বিশ্বস্ত লেনদেন।</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-white mb-1">সহজ ও নিরাপদ</h6>
                            <p class="text-light" style="font-size: 0.95rem;">বিক্রেতা এবং গ্রাহক উভয়ের জন্য সহজ checkout ও
                                payment confirmation।</p>
                        </div>
                        <div>
                            <h6 class="text-white mb-1">বিভিন্ন পণ্য</h6>
                            <p class="text-light" style="font-size: 0.95rem;">অনেক ধরনের কৃষি পণ্য একসাথে দেখুন এবং দ্রুত
                                অর্ডার করুন।</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container py-5">
        <div class="text-center mb-5">
            <h2
                style="font-size: 2.3rem; font-weight: 800; color: #1a1a1a; position: relative; padding-bottom: 12px; display: inline-block;">
                Agro Product Marketplace
                <span
                    style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); width: 50px; height: 4px; background: linear-gradient(90deg, #28a745, #20c997); border-radius: 2px;"></span>
            </h2>
            <p class="text-muted" style="font-size: 1rem; margin-top: 20px;">বাংলাদেশের সেরা কৃষি পণ্যগুলি এক প্ল্যাটফর্মে;
                সরাসরি বিক্রেতার কাছ থেকে কিনুন।</p>
        </div>

        <div class="row g-4">
            @if(isset($topRatedBusiness) && $topRatedBusiness->count() > 0)
                @foreach ($topRatedBusiness as $item)
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ url('business_product_details/' . $item->id) }}" class="text-decoration-none text-dark">
                            <div class="admin-product-card">
                                <div class="admin-product-image-wrapper">
                                    <img src="{{ asset('img_DB/my_business/image_one/' . $item->image_one) }}"
                                        class="admin-product-image" alt="{{ $item->product_name }}">
                                    <div class="admin-card-overlay"></div>
                                    <span class="admin-product-badge">Top Rated</span>
                                </div>

                                <div style="padding: 20px;">
                                    <h5 class="admin-product-title">{{ $item->product_name }}</h5>
                                    <p class="admin-product-desc">
                                        {{ \Illuminate\Support\Str::limit($item->product_description, 70) }}</p>

                                    <div class="admin-rating-row mb-3">
                                        <span class="text-success">{{ number_format($item->ratings_avg_stars_rated, 1) ?? '0.0' }} ⭐</span>
                                        <span class="text-muted">({{ $item->ratings_count ?? 0 }} রেট)</span>
                                    </div>

                                    <div class="admin-price-stock">
                                        <strong class="admin-product-price">৳{{ $item->price }}</strong>
                                        <span class="admin-stock-badge">📦 KG: {{ $item->product_quantity }}</span>
                                    </div>

                                    <div class="admin-location-admin-row">
                                        <span class="admin-location-text">📍
                                            {{ \Illuminate\Support\Str::limit($item->name, 15) }}</span>
                                        <span class="admin-seller-badge">{{ $item->district ?? 'BD' }}</span>
                                    </div>

                                    <button class="admin-details-btn">বিস্তারিত দেখুন →</button>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                @foreach ($lts_business as $item)
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ url('business_product_details/' . $item->id) }}" class="text-decoration-none text-dark">
                            <div class="admin-product-card">
                                <div class="admin-product-image-wrapper">
                                    <img src="{{ asset('img_DB/my_business/image_one/' . $item->image_one) }}"
                                        class="admin-product-image" alt="{{ $item->product_name }}">
                                    <div class="admin-card-overlay"></div>
                                    <span class="admin-product-badge">{{ $item->category ?? 'Agro' }}</span>
                                </div>

                                <div style="padding: 20px;">
                                    <h5 class="admin-product-title">{{ $item->product_name }}</h5>
                                    <p class="admin-product-desc">
                                        {{ \Illuminate\Support\Str::limit($item->product_description, 70) }}</p>

                                    <div class="admin-price-stock">
                                        <strong class="admin-product-price">৳{{ $item->price }}</strong>
                                        <span class="admin-stock-badge">📦 KG: {{ $item->product_quantity }}</span>
                                    </div>

                                    <div class="admin-location-admin-row">
                                        <span class="admin-location-text">📍
                                            {{ \Illuminate\Support\Str::limit($item->name, 15) }}</span>
                                        <span class="admin-seller-badge">{{ $item->district ?? 'BD' }}</span>
                                    </div>

                                    <button class="admin-details-btn">বিস্তারিত দেখুন →</button>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @endif
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
            max-width: 60%;
        }

        .admin-seller-badge {
            background: #6c757d;
            color: white;
            padding: 5px 12px;
            border-radius: 5px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .admin-details-btn {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            color: white;
            padding: 11px 22px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
            font-size: 0.95rem;
        }

        .admin-details-btn:hover {
            background: linear-gradient(135deg, #20c997, #17a2b8);
            transform: translateX(3px);
            color: white;
        }

        .admin-collection-title {
            font-size: 2.3rem;
            font-weight: 800;
            color: #1a1a1a;
            margin-bottom: 12px;
            position: relative;
            padding-bottom: 12px;
        }

        .admin-collection-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 4px;
            background: linear-gradient(90deg, #28a745, #20c997);
            border-radius: 2px;
        }

        .admin-collection-subtitle {
            color: #6c757d;
            font-size: 1rem;
            margin-bottom: 35px;
        }
    </style>

    @if(isset($recommendedProducts) && $recommendedProducts->isNotEmpty())
        <section class="py-5 bg-white">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="admin-collection-title" style="font-size: 2rem; margin-bottom: 6px;">আপনার পছন্দের পণ্য</h2>
                        <p class="admin-collection-subtitle mb-0">আপনার Cart এবং Order-এর উপর ভিত্তি করে সাজানো পণ্যসমূহ।</p>
                    </div>
                    <a href="{{ url('shop') }}" class="btn btn-outline-success">সব পণ্য দেখুন</a>
                </div>

                <div class="row g-4">
                    @foreach ($recommendedProducts as $product)
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ url('product_details/' . $product->id) }}" class="text-decoration-none text-dark">
                                <div class="admin-product-card">
                                    <div class="admin-product-image-wrapper">
                                        <img src="{{ asset('img_DB/product/image_one/' . $product->image_one) }}"
                                            class="admin-product-image" alt="{{ $product->product_name }}">
                                        <div class="admin-card-overlay"></div>
                                        <span class="admin-product-badge">For You</span>
                                    </div>

                                    <div style="padding: 20px;">
                                        <h5 class="admin-product-title">{{ $product->product_name }}</h5>
                                        <p class="admin-product-desc">
                                            {{ \Illuminate\Support\Str::limit($product->description ?? '', 70) }}</p>

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
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="bg-light py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="admin-collection-title">Admin Agro Collection</h2>
                <p class="admin-collection-subtitle">বিশ্বস্ত পরিচালিত পণ্যসমূহ, বিশ্বমানের সার্ভিস সহ।</p>
            </div>

            <div class="row g-4">
                @if(isset($topRatedProducts) && $topRatedProducts->count() > 0)
                    @foreach ($topRatedProducts as $product)
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ url('product_details/' . $product->id) }}" class="text-decoration-none text-dark">
                                <div class="admin-product-card">
                                    <!-- Product Image with Overlay -->
                                    <div class="admin-product-image-wrapper">
                                        <img src="{{ asset('img_DB/product/image_one/' . $product->image_one) }}"
                                            class="admin-product-image" alt="{{ $product->product_name }}">
                                        <div class="admin-card-overlay"></div>
                                        <span class="admin-product-badge">Top Rated</span>
                                    </div>

                                    <!-- Card Body -->
                                    <div style="padding: 20px;">
                                        <h5 class="admin-product-title">{{ $product->product_name }}</h5>
                                        <p class="admin-product-desc">
                                            {{ \Illuminate\Support\Str::limit($product->description ?? '', 70) }}</p>

                                        <!-- Rating -->
                                        <div class="admin-rating-row mb-3">
                                            <span class="text-success">{{ number_format($product->ratings_avg_stars_rated ?? 0, 1) }} ⭐</span>
                                            <span class="text-muted">({{ $product->ratings_count ?? 0 }} রেট)</span>
                                        </div>

                                        <!-- Price & Stock -->
                                        <div class="admin-price-stock">
                                            <strong class="admin-product-price">৳{{ $product->price }}</strong>
                                            <span class="admin-stock-badge">📦 Stock: {{ $product->product_quantity }} kg</span>
                                        </div>

                                        <!-- Location & Admin Badge -->
                                        <div class="admin-location-admin-row">
                                            <span class="admin-location-text">📍 Dhaka</span>
                                            <span class="admin-seller-badge">Admin</span>
                                        </div>

                                        <!-- CTA Button -->
                                        <button class="admin-details-btn">বিস্তারিত দেখুন →</button>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    @foreach ($products as $product)
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ url('product_details/' . $product->id) }}" class="text-decoration-none text-dark">
                                <div class="admin-product-card">
                                    <!-- Product Image with Overlay -->
                                    <div class="admin-product-image-wrapper">
                                        <img src="{{ asset('img_DB/product/image_one/' . $product->image_one) }}"
                                            class="admin-product-image" alt="{{ $product->product_name }}">
                                        <div class="admin-card-overlay"></div>
                                        <span class="admin-product-badge">Admin</span>
                                    </div>

                                    <!-- Card Body -->
                                    <div style="padding: 20px;">
                                        <h5 class="admin-product-title">{{ $product->product_name }}</h5>
                                        <p class="admin-product-desc">
                                            {{ \Illuminate\Support\Str::limit($product->description ?? '', 70) }}</p>

                                        <!-- Price & Stock -->
                                        <div class="admin-price-stock">
                                            <strong class="admin-product-price">৳{{ $product->price }}</strong>
                                            <span class="admin-stock-badge">📦 Stock: {{ $product->product_quantity }} kg</span>
                                        </div>

                                        <!-- Location & Admin Badge -->
                                        <div class="admin-location-admin-row">
                                            <span class="admin-location-text">📍 Dhaka</span>
                                            <span class="admin-seller-badge">Admin</span>
                                        </div>

                                        <!-- CTA Button -->
                                        <button class="admin-details-btn">বিস্তারিত দেখুন →</button>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
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

    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-3" style="font-size: 2rem; color: #1a1a1a;">আমাদের কৃষি পণ্য বিভাগ</h2>
                <p class="text-muted">বাংলাদেশের প্রতিটি অঞ্চল থেকে সংগৃহীত তাজা এবং প্রাকৃতিক পণ্য</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 text-center border-0 shadow-sm" style="border-top: 4px solid #ff6b6b;">
                        <div class="card-body p-4">
                            <h5 style="font-size: 2.5rem; margin-bottom: 10px;">🌾</h5>
                            <h5 class="card-title">শস্য ও দানা</h5>
                            <p class="card-text text-muted">চাল, গম, ভুট্টা, ডাল এবং অন্যান্য শস্য সরাসরি খামার থেকে।</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 text-center border-0 shadow-sm" style="border-top: 4px solid #51cf66;">
                        <div class="card-body p-4">
                            <h5 style="font-size: 2.5rem; margin-bottom: 10px;">🥬</h5>
                            <h5 class="card-title">তাজা সবজি</h5>
                            <p class="card-text text-muted">আলু, পেঁয়াজ, গাজর, বেগুন, টমেটো এবং মৌসুমী সবজি।</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 text-center border-0 shadow-sm" style="border-top: 4px solid #ffc107;">
                        <div class="card-body p-4">
                            <h5 style="font-size: 2.5rem; margin-bottom: 10px;">🍌</h5>
                            <h5 class="card-title">তাজা ফল</h5>
                            <p class="card-text text-muted">কলা, আম, লিচু, আনারস, পেয়ারা এবং ঋতুভিত্তিক ফল।</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 text-center border-0 shadow-sm" style="border-top: 4px solid #ff8c42;">
                        <div class="card-body p-4">
                            <h5 style="font-size: 2.5rem; margin-bottom: 10px;">🌶️</h5>
                            <h5 class="card-title">মসলা ও তৈল</h5>
                            <p class="card-text text-muted">হলুদ, মরিচ, পেঁয়াজের গুঁড়ো এবং বিভিন্ন প্রাকৃতিক তৈল।</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h3 class="fw-bold mb-3" style="font-size: 1.8rem;">কেন AgroBd বেছে নিবেন?</h3>
                    <ul class="list-unstyled" style="line-height: 2.5;">
                        <li>✅ <strong>সরাসরি কৃষক থেকে ক্রেতা:</strong> মধ্যস্থতাকারী নেই, ন্যায্য মূল্য নিশ্চিত।</li>
                        <li>✅ <strong>সর্বোচ্চ মানের পণ্য:</strong> প্রতিটি পণ্য যাচাই ও নিয়ন্ত্রণ করা হয়।</li>
                        <li>✅ <strong>সারাদেশে ডেলিভারি:</strong> ঢাকা, চট্টগ্রাম, সিলেট সহ সব জেলায় পৌঁছাই।</li>
                        <li>✅ <strong>নিরাপদ লেনদেন:</strong> একাধিক পেমেন্ট পদ্ধতি এবং সম্পূর্ণ নিরাপত্তা।</li>
                        <li>✅ <strong>টেকসই কৃষি:</strong> আমরা জৈব এবং প্রাকৃতিক কৃষিকে সমর্থন করি।</li>
                    </ul>
                </div>
                <div class="col-lg-6">
                    <div class="bg-light p-5 rounded-4" style="border-left: 5px solid #28a745;">
                        <h5 class="fw-bold mb-3 text-success">আমাদের প্রতিশ্রুতি</h5>
                        <p class="mb-3" style="line-height: 1.8;">
                            "আমরা বিশ্বাস করি যে প্রযুক্তি এবং কৃষির সমন্বয়ে একটি শক্তিশালী ভবিষ্যৎ গড়া সম্ভব। প্রতিটি অর্ডারের মাধ্যমে আপনি বাংলাদেশের কৃষকদের স্বনির্ভর করতে সাহায্য করছেন এবং নিজেও সর্বোত্তম মানের পণ্য পাচ্ছেন।"
                        </p>
                        <p class="text-muted"><em>— AgroBd টিম</em></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
