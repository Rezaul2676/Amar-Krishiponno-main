@extends('layouts.frontend_layout')

@section('title')
    AgroBd - {{ $business->product_name }}
@endsection

@section('frontend_content')
    <!-- Rating Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <i class="fas fa-star"></i> ⭐ {{ $business->product_name }} এর রেটিং দিন
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ url('business_add_rating') }}" method="POST">
                    @csrf
                    <input type="hidden" name="business_product_id" value="{{ $business->id }}">
                    <div class="modal-body p-4">
                        <div class="rating-css text-center">
                            <h6 class="mb-3 text-muted">এই পণ্যের গুণমান কেমন ছিল?</h6>
                            <div class="star-icon">
                                @if ($user_rating)
                                    @for ($i = 1; $i <= $user_rating->stars_rated; $i++)
                                        <input type="radio" value="{{ $i }}" name="product_rating" checked
                                            id="rating{{ $i }}">
                                        <label for="rating{{ $i }}" class="fa fa-star"></label>
                                    @endfor
                                    @for ($j = $user_rating->stars_rated + 1; $j <= 5; $j++)
                                        <input type="radio" value="{{ $j }}" name="product_rating"
                                            id="rating{{ $j }}">
                                        <label for="rating{{ $j }}" class="fa fa-star"></label>
                                    @endfor
                                @else
                                    <input type="radio" value="1" name="product_rating" checked id="rating1">
                                    <label for="rating1" class="fa fa-star"></label>
                                    <input type="radio" value="2" name="product_rating" id="rating2">
                                    <label for="rating2" class="fa fa-star"></label>
                                    <input type="radio" value="3" name="product_rating" id="rating3">
                                    <label for="rating3" class="fa fa-star"></label>
                                    <input type="radio" value="4" name="product_rating" id="rating4">
                                    <label for="rating4" class="fa fa-star"></label>
                                    <input type="radio" value="5" name="product_rating" id="rating5">
                                    <label for="rating5" class="fa fa-star"></label>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> বাতিল
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> রেটিং দিন
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Page Header -->
    <section class="page-header-section bg-success text-white py-5 mt-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item">
                                <a href="{{ url('/') }}" class="text-white text-decoration-none">
                                    <i class="fas fa-home"></i> হোম
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ url('my_business') }}" class="text-white text-decoration-none">
                                    <i class="fas fa-store"></i> ব্যবসা
                                </a>
                            </li>
                            <li class="breadcrumb-item active text-light" aria-current="page">
                                {{ $business->category }}
                            </li>
                        </ol>
                    </nav>
                    <h1 class="display-5 fw-bold mb-0">{{ $business->product_name }}</h1>
                    <p class="lead mb-0 opacity-75">🌾 বাংলাদেশের সেরা কৃষি পণ্য</p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <form action="{{ url('search_business_query') }}" method="GET" class="search-form">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="query" class="form-control form-control-lg"
                                placeholder="🔍 পণ্য খুঁজুন..." value="{{ request()->input('query') }}">
                            <button class="btn btn-light btn-lg" type="submit">
                                <i class="fas fa-search text-success"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Details Section -->
    <section class="product-details-section py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <!-- Product Images -->
                <div class="col-lg-6">
                    <div class="product-image-container bg-white p-4 rounded-3 shadow-sm">
                        <div class="main-image-wrapper mb-4 position-relative overflow-hidden rounded-3"
                            style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                            <img class="img-fluid w-100 main-product-image"
                                src="{{ asset('img_DB/my_business/image_one/' . $business->image_one) }}"
                                id="display_img" alt="{{ $business->product_name }}"
                                style="height: 400px; object-fit: contain;">
                            <div class="image-overlay">
                                <i class="fas fa-search-plus text-white fs-3"></i>
                            </div>
                        </div>

                        <div class="thumbnail-gallery d-flex gap-3 flex-wrap">
                            <div class="thumbnail-item active"
                                onclick="changeImage(this, '{{ asset('img_DB/my_business/image_one/' . $business->image_one) }}')">
                                <img src="{{ asset('img_DB/my_business/image_one/' . $business->image_one) }}"
                                    class="img-fluid rounded-2" alt="Main Image">
                            </div>
                            <div class="thumbnail-item"
                                onclick="changeImage(this, '{{ asset('img_DB/my_business/image_two/' . $business->image_two) }}')">
                                <img src="{{ asset('img_DB/my_business/image_two/' . $business->image_two) }}"
                                    class="img-fluid rounded-2" alt="Image 2">
                            </div>
                            <div class="thumbnail-item"
                                onclick="changeImage(this, '{{ asset('img_DB/my_business/image_three/' . $business->image_three) }}')">
                                <img src="{{ asset('img_DB/my_business/image_three/' . $business->image_three) }}"
                                    class="img-fluid rounded-2" alt="Image 3">
                            </div>
                            <div class="thumbnail-item"
                                onclick="changeImage(this, '{{ asset('img_DB/my_business/image_four/' . $business->image_four) }}')">
                                <img src="{{ asset('img_DB/my_business/image_four/' . $business->image_four) }}"
                                    class="img-fluid rounded-2" alt="Image 4">
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons mt-4 d-flex gap-2 flex-wrap">
                            <button type="button" class="btn btn-outline-success flex-fill" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <i class="fas fa-star"></i> রেটিং দিন
                            </button>
                            <a href="{{ url('add_review_business/' . $business->id) }}"
                                class="btn btn-warning flex-fill">
                                <i class="fas fa-comment"></i> রিভিউ লিখুন
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Product Information -->
                <div class="col-lg-6">
                    <div class="product-info-card bg-white p-4 rounded-3 shadow-sm h-100">
                        <div class="product-header mb-4">
                            <div class="category-badge mb-3">
                                <span class="badge bg-success fs-6 px-3 py-2">
                                    <i class="fas fa-tag"></i> {{ $business->category }}
                                </span>
                            </div>
                            <h2 class="product-title mb-3">{{ $business->product_name }}</h2>

                            <!-- Price Section -->
                            <div class="price-section bg-success bg-opacity-10 p-3 rounded-3 mb-3">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h3 class="text-success fw-bold mb-0 fs-2 text-white">
                                            ৳{{ number_format((float) $business->price) }}
                                        </h3>
                                    </div>
                                    <div class="text-end">
                                        <i class="fas fa-money-bill-wave text-success fs-1"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Rating Section -->
                            <div class="rating-section mb-3">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    @php $ratenum = number_format((float)$rating_value) @endphp
                                    @for ($i = 1; $i <= $ratenum; $i++)
                                        <i class="fas fa-star text-warning"></i>
                                    @endfor
                                    @for ($j = $ratenum + 1; $j <= 5; $j++)
                                        <i class="far fa-star text-warning"></i>
                                    @endfor
                                    <span class="text-muted ms-2">
                                        ({{ $ratings->count() > 0 ? $ratings->count() : 'কোন' }} রেটিং)
                                    </span>
                                </div>
                            </div>

                            <!-- Stock Status -->
                            <div class="stock-status mb-4">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="fas fa-warehouse text-success"></i>
                                    <strong>{{ $business->product_name }}:</strong>
                                    @if ($business->product_quantity > 0)
                                        <span class="badge bg-success fs-6 px-3 py-2">
                                            <i class="fas fa-check"></i> {{ $business->product_quantity }} কেজি 
                                        </span>
                                    @else
                                        <span class="badge bg-danger fs-6 px-3 py-2">
                                            <i class="fas fa-times"></i> স্টক শেষ
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Purchase Section -->
                            @if ($business->product_quantity > 0)
                                <div class="purchase-section bg-light p-3 rounded-3 mb-4">
                                    <h5 class="mb-3">
                                        <i class="fas fa-shopping-cart text-success"></i> ক্রয় করুন
                                    </h5>
                                    <div class="row g-3 align-items-end">
                                        {{--
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">পরিমাণ</label>
                                            <div class="input-group">
                                                <button type="button" class="btn btn-outline-secondary"
                                                    id="quantity-decrease">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="number" name="quantity" id="quantity-input"
                                                    class="form-control text-center fw-bold" value="1"
                                                    min="1" max="{{ $business->product_quantity }}" required>
                                                <button type="button" class="btn btn-outline-secondary"
                                                    id="quantity-increase">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        --}}

                                        <div class="col-md-6 d-grid gap-2">
                                            <!-- <form action="{{ url('cart_add/' . $business->id) }}" method="POST"
                                                class="d-grid">
                                                @csrf
                                                <input type="hidden" name="qty" id="business-cart-qty" value="1">
                                                <input type="hidden" name="price" value="{{ $business->price }}">
                                                <button type="submit" class="btn btn-primary btn-lg w-100">
                                                    <i class="fas fa-cart-plus"></i> কার্টে যোগ করুন
                                                </button>
                                            </form> -->

                                            <a href="{{ url('add_to_wishlist/' . $business->id) }}" class="btn btn-outline-success flex-fill">
                                               <i class="fas fa-heart"></i> প্রিয়তে যুক্ত করুন
                                            </a>

                                            <form action="{{ url('business_payment/' . $business->id) }}" method="GET"
                                                class="d-grid">
                                                <input type="hidden" name="quantity" id="business-payment-qty"
                                                    value="1">
                                                <button type="submit" class="btn btn-success btn-lg w-100">
                                                    <i class="fas fa-credit-card"></i> এখনই কিনুন
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif

                                <!-- <div class="d-flex gap-2 flex-wrap mt-4">
                                    <a href="{{ url('add-review/' . $business->id) }}" class="btn btn-warning flex-fill">
                                        <i class="fas fa-comment"></i> রিভিউ লিখুন
                                    </a>
                                    
                                </div> -->

                            <!-- Product Description -->
                            <div class="product-description">
                                <h5 class="mb-3">
                                    <i class="fas fa-info-circle text-success"></i> পণ্যের বিবরণ
                                </h5>
                                <div class="description-content text-justify">
                                    <p class="mb-0">{{ $business->product_description }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Seller Contact Information -->
    <section class="seller-contact-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="contact-card bg-white p-4 rounded-3 shadow-sm">
                        <div class="card-header bg-success text-white p-3 rounded-top-3">
                            <h4 class="mb-0">
                                <i class="fas fa-user-circle"></i> বিক্রেতার তথ্য - {{ $business->product_name }}
                            </h4>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="contact-item d-flex align-items-center p-3 bg-light rounded-2">
                                        <div class="contact-icon text-success me-3">
                                            <i class="fas fa-user fs-4"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">নাম</small>
                                            <strong>{{ $business->name }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="contact-item d-flex align-items-center p-3 bg-light rounded-2">
                                        <div class="contact-icon text-success me-3">
                                            <i class="fas fa-envelope fs-4"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">ইমেইল</small>
                                            <strong>
                                                <a href="mailto:{{ $business->email }}" class="text-decoration-none">
                                                    {{ $business->email }}
                                                </a>
                                            </strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="contact-item d-flex align-items-center p-3 bg-light rounded-2">
                                        <div class="contact-icon text-success me-3">
                                            <i class="fas fa-phone fs-4"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">ফোন</small>
                                            <strong>
                                                <a href="tel:{{ $business->phone }}" class="text-decoration-none">
                                                    {{ $business->phone }}
                                                </a>
                                            </strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="contact-item d-flex align-items-center p-3 bg-light rounded-2">
                                        <div class="contact-icon text-success me-3">
                                            <i class="fas fa-map-marker-alt fs-4"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">ঠিকানা</small>
                                            <strong>{{ $business->village }}, {{ $business->district }}</strong>
                                        </div>
                                    </div>
                                </div>

                                @if ($business->personal_description)
                                    <div class="col-12">
                                        <div class="contact-item p-3 bg-light rounded-2">
                                            <div class="d-flex align-items-start">
                                                <div class="contact-icon text-success me-3 mt-1">
                                                    <i class="fas fa-info-circle fs-4"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <small class="text-muted d-block">অতিরিক্ত তথ্য</small>
                                                    <strong>{{ $business->personal_description }}</strong>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Reviews Section -->
    <section class="reviews-section py-5 bg-light">
        <div class="container">
            <div class="reviews-card bg-white p-4 rounded-3 shadow-sm">
                <div class="reviews-header d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0">
                        <i class="fas fa-comments text-success"></i> গ্রাহকদের রিভিউ
                    </h3>
                    <a href="{{ url('add_review_business/' . $business->id) }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> রিভিউ লিখুন
                    </a>
                </div>

                @if ($reviews->count() > 0)
                    <div class="reviews-list">
                        @foreach ($reviews as $item)
                            <div class="review-item border-bottom pb-4 mb-4">
                                <div class="review-header d-flex justify-content-between align-items-start mb-3">
                                    <div class="reviewer-info">
                                        <h6 class="mb-1">
                                            <i class="fas fa-user-circle text-success"></i> {{ $item->name }}
                                        </h6>
                                        <div class="review-rating mb-2">
                                            @php
                                                $rating = App\Models\Business\RatingBusiness::where(
                                                    'prod_id',
                                                    $business->id,
                                                )
                                                    ->where('user_id', $item->user_id)
                                                    ->first();
                                            @endphp
                                            @if ($rating)
                                                @php $user_rated = $rating->stars_rated; @endphp
                                                @for ($i = 1; $i <= $user_rated; $i++)
                                                    <i class="fas fa-star text-warning"></i>
                                                @endfor
                                                @for ($j = $user_rated + 1; $j <= 5; $j++)
                                                    <i class="far fa-star text-muted"></i>
                                                @endfor
                                            @endif
                                        </div>
                                        <small class="text-muted">
                                            <i class="fas fa-clock"></i> {{ $item->created_at->diffForHumans() }}
                                        </small>
                                    </div>

                                    @if ($item->user_id == Auth::id())
                                        <div class="review-actions">
                                            <a href="{{ url('edit_review_business/' . $item->id) }}"
                                                class="btn btn-sm btn-outline-success me-2">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ url('delete_review_business/' . $item->id) }}"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('আপনি কি এই রিভিউ মুছে ফেলতে চান?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                <div class="review-content">
                                    <p class="mb-0 text-justify">{{ $item->user_review }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if ($reviews->count() > 2)
                        <div class="text-center mt-4">
                            <a href="{{ url('review_more_business/' . $business->id) }}" class="btn btn-success">
                                <i class="fas fa-eye"></i> আরও রিভিউ দেখুন
                            </a>
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-comments text-muted fs-1 mb-3"></i>
                        <h5 class="text-muted">এখনও কোন রিভিউ নেই</h5>
                        <p class="text-muted mb-4">প্রথম রিভিউ লিখে অন্যদের সাহায্য করুন</p>
                        <a href="{{ url('add_review_business/' . $business->id) }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> রিভিউ লিখুন
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Related Products Section -->
    <section class="related-products-section py-5">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2 class="display-6 fw-bold text-success mb-3">
                    <i class="fas fa-leaf"></i> অন্যান্য পণ্য দেখুন
                </h2>
                <p class="lead text-muted">amar-krishiponno থেকে আরও সেরা কৃষি পণ্য</p>
                <div class="divider mx-auto"></div>
            </div>

            <div class="row g-4">
                @foreach ($lts_business->take(8) as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="product-card bg-white rounded-3 shadow-sm overflow-hidden h-100">
                            <div class="product-image position-relative">
                                <img src="{{ asset('img_DB/my_business/image_one/' . $product->image_one) }}"
                                    class="img-fluid w-100" alt="{{ $product->product_name }}"
                                    style="height: 200px; object-fit: cover;">
                                <div class="product-overlay">
                                    <a href="{{ url('business_product_details/' . $product->id) }}"
                                        class="btn btn-success btn-sm">
                                        <i class="fas fa-eye"></i> বিস্তারিত দেখুন
                                    </a>
                                </div>
                                @if ($product->product_quantity > 0)
                                    <div class="stock-badge">
                                        <span class="badge bg-success">
                                            <i class="fas fa-check"></i> মজুদ আছে
                                        </span>
                                    </div>
                                @else
                                    <div class="stock-badge">
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times"></i> স্টক শেষ
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <div class="product-info p-3">
                                <div class="category-badge mb-2">
                                    <small class="text-success fw-bold">{{ $product->category }}</small>
                                </div>
                                <h6 class="product-title mb-2 fw-bold">{{ $product->product_name }}</h6>
                                <div class="price-info">
                                    <span
                                        class="text-success fw-bold fs-5">৳{{ number_format((float) $product->price) }}</span>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-4">
                <a href="{{ url('my_business') }}" class="btn btn-success btn-lg">
                    <i class="fas fa-store"></i> সব পণ্য দেখুন
                </a>
            </div>
        </div>
    </section>

    <style>
        /* Page Header */
        .page-header-section {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            box-shadow: 0 4px 20px rgba(40, 167, 69, 0.3);
        }

        .breadcrumb {
            background: none;
            padding: 0;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: "›";
            color: rgba(255, 255, 255, 0.8);
        }

        .breadcrumb-item a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            color: white;
        }

        /* Product Images */
        .product-image-container {
            border: 1px solid #e9ecef;
        }

        .main-image-wrapper {
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .main-image-wrapper:hover {
            transform: scale(1.02);
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .main-image-wrapper:hover .image-overlay {
            opacity: 1;
        }

        .thumbnail-gallery {
            justify-content: center;
        }

        .thumbnail-item {
            width: 80px;
            height: 80px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .thumbnail-item:hover,
        .thumbnail-item.active {
            border-color: #28a745;
            box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.2);
        }

        .thumbnail-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Product Info */
        .product-info-card {
            border: 1px solid #e9ecef;
        }

        .category-badge .badge {
            font-size: 0.75rem;
        }

        .product-title {
            color: #2d3748;
            line-height: 1.3;
        }

        .price-section {
            border: 2px solid #28a745;
        }

        .rating-section .fa-star {
            font-size: 1.1rem;
        }

        .stock-status .badge {
            font-size: 0.75rem;
        }

        .purchase-section {
            border: 1px solid #dee2e6;
        }

        .input-group button {
            border-color: #dee2e6;
        }

        .input-group button:hover {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }

        /* Hide clear button on number input */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        /* Contact Section */
        .contact-card {
            border: 1px solid #e9ecef;
        }

        .contact-item {
            transition: transform 0.2s ease;
        }

        .contact-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .contact-icon {
            min-width: 40px;
        }

        /* Reviews Section */
        .reviews-card {
            border: 1px solid #e9ecef;
        }

        .review-item {
            transition: all 0.3s ease;
        }

        .review-item:hover {
            background-color: #f8f9fa;
            padding-left: 10px;
            margin-left: -10px;
            border-radius: 8px;
        }

        .review-rating .fa-star {
            font-size: 0.9rem;
        }

        /* Related Products */
        .section-header .divider {
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, #28a745, #20c997);
            margin: 1rem auto;
        }

        .product-card {
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .product-image {
            position: relative;
            overflow: hidden;
        }

        .product-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(40, 167, 69, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .product-card:hover .product-overlay {
            opacity: 1;
        }

        .stock-badge {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        /* Rating Modal */
        .rating-css .fa-star {
            font-size: 2rem;
            color: #ddd;
            margin: 0 5px;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .rating-css input[type="radio"] {
            display: none;
        }

        .rating-css input[type="radio"]:checked~label,
        .rating-css label:hover,
        .rating-css label:hover~label {
            color: #ffc107;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-header-section .display-5 {
                font-size: 2rem;
            }

            .thumbnail-gallery {
                gap: 0.5rem;
            }

            .thumbnail-item {
                width: 60px;
                height: 60px;
            }

            .product-image-container,
            .product-info-card {
                margin-bottom: 1rem;
            }

            .contact-item {
                margin-bottom: 0.5rem;
            }

            .related-products-section .col-lg-3 {
                margin-bottom: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .page-header-section {
                padding: 2rem 0;
            }

            .page-header-section .display-5 {
                font-size: 1.5rem;
            }

            .thumbnail-gallery {
                justify-content: space-between;
            }

            .purchase-section .col-6 {
                margin-bottom: 1rem;
            }

            .action-buttons .btn {
                margin-bottom: 0.5rem;
            }
        }
    </style>

@endsection

@section('scripts')
    <script>
        // Image switching functionality
        function changeImage(element, imageSrc) {
            // Update main image
            document.getElementById('display_img').src = imageSrc;

            // Update active thumbnail
            document.querySelectorAll('.thumbnail-item').forEach(item => {
                item.classList.remove('active');
            });
            element.classList.add('active');
        }

        // Quantity controls
        document.addEventListener('DOMContentLoaded', function() {
            const decreaseBtn = document.getElementById('quantity-decrease');
            const increaseBtn = document.getElementById('quantity-increase');
            const quantityInput = document.getElementById('quantity-input');
            const maxQuantity = parseInt(quantityInput.getAttribute('max'), 10) || 1;

            function updateQuantity(delta) {
                let value = parseInt(quantityInput.value, 10) || 1;
                value += delta;
                if (value < 1) value = 1;
                if (value > maxQuantity) value = maxQuantity;
                quantityInput.value = value;
                syncBusinessQuantity();
            }

            if (decreaseBtn) {
                decreaseBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    updateQuantity(-1);
                });
            }

            if (increaseBtn) {
                increaseBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    updateQuantity(1);
                });
            }

            function syncBusinessQuantity() {
                const cartQtyInput = document.getElementById('business-cart-qty');
                const paymentQtyInput = document.getElementById('business-payment-qty');
                if (cartQtyInput) {
                    cartQtyInput.value = quantityInput.value;
                }
                if (paymentQtyInput) {
                    paymentQtyInput.value = quantityInput.value;
                }
            }

            quantityInput.addEventListener('input', syncBusinessQuantity);
            syncBusinessQuantity();

            // Initialize first thumbnail as active
            const firstThumbnail = document.querySelector('.thumbnail-item');
            if (firstThumbnail) {
                firstThumbnail.classList.add('active');
            }
        });
    </script>
@endsection
