@extends('layouts.frontend_layout')


@section('title')
    AgroBd - Category Products
@endsection


@section('frontend_content')
    <section id="blog-home " class="mt-5 pt-5 container">
        <h2 class="font-weight-bold ">বিভাগ অনুযায়ী কৃষি পণ্য</h2>
        <p class="text-muted">আপনার প্রয়োজনীয় কৃষি পণ্য সহজেই খুঁজে পেতে বিভাগ নির্বাচন করুন</p>
        <hr>
    </section>


    <section class=" container featured mt-4  pb-5 ">

        <div class="row">


            <div class="col-lg-3 col-md-4 col-12 mt-4 ">


                <div class="hero__categories">
                    <div class="hero__categories__all">
                        <i class="fa fa-bars"></i>
                        <span style="color: black">All Category</span>
                    </div>

                    @php
                        $categories = App\Models\Category::where('status', 1)->get();
                    @endphp
                    <div class="overflow">
                        <ul>
                            @foreach ($categories as $row)
                                <li><a href="{{ url('category_product_show/' . $row->id) }}">{{ $row->category_name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>



            <div class="col-lg-9 col-md-8 col-12  mt-4 ">

                <style>
                    .shop-product-card {
                        height: 100%;
                        border: none;
                        border-radius: 12px;
                        overflow: hidden;
                        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
                        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.1);
                        background: white;
                        display: flex;
                        flex-direction: column;
                    }

                    .shop-product-card:hover {
                        transform: translateY(-12px);
                        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
                    }

                    .shop-product-image-wrapper {
                        position: relative;
                        height: 240px;
                        overflow: hidden;
                        background: #f0f0f0;
                    }

                    .shop-product-image {
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                        transition: transform 0.4s ease;
                    }

                    .shop-product-card:hover .shop-product-image {
                        transform: scale(1.1);
                    }

                    .shop-card-overlay {
                        position: absolute;
                        inset: 0;
                        background: linear-gradient(180deg, transparent 50%, rgba(0, 0, 0, 0.2) 100%);
                        opacity: 0;
                        transition: opacity 0.3s ease;
                    }

                    .shop-product-card:hover .shop-card-overlay {
                        opacity: 1;
                    }

                    .shop-product-badge {
                        position: absolute;
                        top: 12px;
                        left: 12px;
                        background: #28a745;
                        color: white;
                        padding: 7px 14px;
                        border-radius: 50px;
                        font-weight: 700;
                        font-size: 0.75rem;
                        box-shadow: 0 3px 8px rgba(40, 167, 69, 0.3);
                        z-index: 2;
                        letter-spacing: 0.5px;
                    }

                    .shop-product-title {
                        font-size: 1.13rem;
                        font-weight: 700;
                        color: #1a1a1a;
                        margin-bottom: 10px;
                        line-height: 1.4;
                    }

                    .shop-product-desc {
                        color: #666;
                        font-size: 0.85rem;
                        min-height: 45px;
                        line-height: 1.6;
                        margin-bottom: 12px;
                        flex-grow: 1;
                    }

                    .shop-meta-section {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        margin-bottom: 12px;
                        font-size: 0.9rem;
                    }

                    .shop-product-price {
                        font-size: 1.35rem;
                        font-weight: 800;
                        color: #28a745;
                    }

                    .shop-stock-info {
                        background: #f0f8f5;
                        color: #2d7a4a;
                        padding: 5px 10px;
                        border-radius: 5px;
                        font-size: 0.75rem;
                        font-weight: 700;
                    }

                    .shop-location-admin {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        margin-bottom: 13px;
                        padding-bottom: 12px;
                        border-bottom: 1px solid #e9ecef;
                    }

                    .shop-admin-info {
                        display: flex;
                        align-items: center;
                        gap: 8px;
                        font-size: 0.85rem;
                        color: #666;
                    }

                    .shop-admin-location-badge {
                        background: #6c757d;
                        color: white;
                        padding: 5px 12px;
                        border-radius: 4px;
                        font-weight: 600;
                        font-size: 0.75rem;
                    }

                    .shop-location-pin {
                        color: #e74c3c;
                        font-weight: bold;
                    }

                    .shop-details-btn {
                        background: linear-gradient(135deg, #28a745, #20c997);
                        border: none;
                        color: white;
                        padding: 12px 18px;
                        border-radius: 6px;
                        font-weight: 700;
                        transition: all 0.3s ease;
                        width: 100%;
                        font-size: 0.9rem;
                    }

                    .shop-details-btn:hover {
                        background: linear-gradient(135deg, #20c997, #17a2b8);
                        transform: translateX(2px);
                        color: white;
                        text-decoration: none;
                    }
                </style>

                <div class="row g-4">
                    @foreach ($products as $product)
                        <div class="col-lg-4 col-md-6 col-12">
                            <a href="{{ url('product_details/' . $product->id) }}" class="text-decoration-none text-dark">
                                <div class="shop-product-card">
                                    <!-- Product Image with Overlay -->
                                    <div class="shop-product-image-wrapper">
                                        <img class="shop-product-image"
                                            src="{{ asset('img_DB/product/image_one/' . $product->image_one) }}"
                                            alt="{{ $product->product_name }}">
                                        <div class="shop-card-overlay"></div>
                                        <span class="shop-product-badge">বিশেষ</span>
                                    </div>

                                    <!-- Card Body -->
                                    <div style="padding: 16px; display: flex; flex-direction: column;">
                                        <h5 class="shop-product-title">{{ $product->product_name }}</h5>

                                        <p class="shop-product-desc">
                                            {{ \Illuminate\Support\Str::limit($product->product_description ?? '', 55) }}
                                        </p>

                                        <!-- Price Section -->
                                        <div class="shop-meta-section">
                                            <strong class="shop-product-price">৳{{ $product->price }}</strong>
                                            <span class="shop-stock-info">📦 {{ $product->product_quantity }} kg</span>
                                        </div>

                                        <!-- Location & Admin Info -->
                                        <div class="shop-location-admin">
                                            <div class="shop-admin-info">
                                                <span class="shop-location-pin">📍</span>
                                                <span>Admin</span>
                                            </div>
                                            <span class="shop-admin-location-badge">Dhaka</span>
                                        </div>

                                        <!-- CTA Button -->
                                        <button class="shop-details-btn">বিস্তারিত দেখুন →</button>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>


        <div class="d-flex mt-5">
            {{-- (paginate) ->Providers\AppServiceProvider.php --}}
            {{ $products->links() }}
            {{-- {{$appoint->onEachSide(1)-> links()}} --}}
        </div>



    </section>
@endsection
