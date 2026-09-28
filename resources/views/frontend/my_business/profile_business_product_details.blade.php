@extends('layouts.frontend_layout')


@section('title')
    AgroBd - Profile Product Details
@endsection


@section('frontend_content')
    <!-- Breadcrumb and Action Buttons -->
    <div class="container mt-5 pt-3 ">
        <div class="row align-items-center mb-4 mt-5">
            <div class="col-md-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ url('business_profile') }}" class="text-decoration-none">My
                                Business Profile</a></li>
                        <li class="breadcrumb-item active">{{ $business->category }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-6 text-md-end">
                <div class="action-buttons d-flex gap-2 flex-wrap">
                    @if ($business->status == 1)
                        <a href="{{ url('business_zero/' . $business->id) }}" class="btn btn-sm btn-danger"
                            title="Deactivate">
                            <i class="fa fa-arrow-down"></i> Deactivate
                        </a>
                    @else
                        <a href="{{ url('business_one/' . $business->id) }}" class="btn btn-sm btn-success"
                            title="Activate">
                            <i class="fa fa-arrow-up"></i> Activate
                        </a>
                    @endif

                    <a href="{{ url('edit_business/' . $business->id) }}" class="btn btn-sm btn-warning text-dark"
                        title="Edit">
                        <i class="fa fa-edit"></i> Edit
                    </a>

                    <a href="{{ url('delete_business/' . $business->id) }}" class="btn btn-sm btn-danger"
                        onclick="return confirm('Are you sure you want to delete this product?')" title="Delete">
                        <i class="fa fa-trash"></i> Delete
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Details Section -->
    <section class="container product_details mb-5">
        <div class="row g-4">
            <!-- Product Images -->
            <div class="col-lg-5">
                <div class="product-image-container">
                    <div class="main-image-wrapper mb-3 rounded overflow-hidden" style="background-color: #f0f0f0;">
                        <img class="img-fluid w-100"
                            src="{{ asset('img_DB/my_business/image_one/' . $business->image_one) }}" id="display_img"
                            alt="{{ $business->product_name }}">
                    </div>

                    <div class="small-img-group d-flex gap-2 flex-wrap">
                        <div class="small-img-col" style="flex: 0 0 calc(25% - 0.5rem);">
                            <img src="{{ asset('img_DB/my_business/image_two/' . $business->image_two) }}"
                                class="small-img img-thumbnail w-100 cursor-pointer" style="cursor: pointer;"
                                onclick="myFunctionimg(this)" alt="">
                        </div>
                        <div class="small-img-col" style="flex: 0 0 calc(25% - 0.5rem);">
                            <img src="{{ asset('img_DB/my_business/image_three/' . $business->image_three) }}"
                                class="small-img img-thumbnail w-100 cursor-pointer" style="cursor: pointer;"
                                onclick="myFunctionimg(this)" alt="">
                        </div>
                        <div class="small-img-col" style="flex: 0 0 calc(25% - 0.5rem);">
                            <img src="{{ asset('img_DB/my_business/image_four/' . $business->image_four) }}"
                                class="small-img img-thumbnail w-100 cursor-pointer" style="cursor: pointer;"
                                onclick="myFunctionimg(this)" alt="">
                        </div>
                        <div class="small-img-col" style="flex: 0 0 calc(25% - 0.5rem);">
                            <img src="{{ asset('img_DB/my_business/image_one/' . $business->image_one) }}"
                                class="small-img img-thumbnail w-100 cursor-pointer" style="cursor: pointer;"
                                onclick="myFunctionimg(this)" alt="">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Information -->
            <div class="col-lg-7">
                <div class="product-info">
                    <h1 class="mb-2 fw-bold">{{ $business->product_name }}</h1>
                    <p class="text-muted mb-3">
                        <small>Category: <strong>{{ $business->category }}</strong></small>
                    </p>

                    <!-- Price -->
                    <div class="price-section mb-3">
                        <h3 class="text-success fw-bold">
                            ৳{{ $business->price }} <small class="text-muted fs-6"></small>
                        </h3>
                    </div>

                    <!-- Availability -->
                    <div class="availability-section mb-4">
                        <h6 class="mb-2"><strong>Availability:</strong></h6>
                        @if ($business->product_quantity > 0)
                            <span class="badge bg-success p-2">
                                <i class="fas fa-check-circle"></i> {{ $business->product_quantity }} kg 
                            </span>
                        @else
                            <span class="badge bg-danger p-2">
                                <i class="fas fa-times-circle"></i> Out of Stock
                            </span>
                        @endif
                    </div>

                    <!-- Divider -->
                    <hr class="my-4">

                    <!-- Product Description -->
                    <div class="description-section mb-4">
                        <h5 class="fw-bold mb-3">Product Details</h5>
                        <p class="text-justify" style="line-height: 1.8;">
                            {{ $business->product_description }}
                        </p>
                    </div>

                    <!-- Contact Card -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header" style="background-color: #81B622; color: white;">
                            <h5 class="mb-0"><strong><i class="fas fa-phone"></i> Contact Seller for
                                    {{ $business->product_name }}</strong></h5>
                        </div>

                        <div class="card-body">
                            <div class="row g-3">
                                <!-- Name -->
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <small class="text-muted d-block">Name</small>
                                        <strong>{{ $business->name }}</strong>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <small class="text-muted d-block">Email</small>
                                        <strong><a href="mailto:{{ $business->email }}" class="text-decoration-none">
                                                {{ $business->email }}
                                            </a></strong>
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <small class="text-muted d-block">Phone</small>
                                        <strong><a href="tel:{{ $business->phone }}" class="text-decoration-none">
                                                {{ $business->phone }}
                                            </a></strong>
                                    </div>
                                </div>

                                <!-- Village/House -->
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <small class="text-muted d-block">Village/House</small>
                                        <strong>{{ $business->village }}</strong>
                                    </div>
                                </div>

                                <!-- Road/Block/Sector -->
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <small class="text-muted d-block">Road/Block/Sector</small>
                                        <strong>{{ $business->road }}</strong>
                                    </div>
                                </div>

                                <!-- Police Station -->
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <small class="text-muted d-block">Police Station</small>
                                        <strong>{{ $business->police_station }}</strong>
                                    </div>
                                </div>

                                <!-- Post Office -->
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <small class="text-muted d-block">Post Office</small>
                                        <strong>{{ $business->post_office }}</strong>
                                    </div>
                                </div>

                                <!-- District -->
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <small class="text-muted d-block">District</small>
                                        <strong>{{ $business->district }}</strong>
                                    </div>
                                </div>

                                <!-- Post Code -->
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <small class="text-muted d-block">Post Code</small>
                                        <strong>{{ $business->post_code }}</strong>
                                    </div>
                                </div>

                                <!-- Country -->
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <small class="text-muted d-block">Country</small>
                                        <strong>{{ $business->country }}</strong>
                                    </div>
                                </div>

                                <!-- About Address -->
                                <div class="col-12">
                                    <div class="info-item">
                                        <small class="text-muted d-block">About This Address</small>
                                        <strong>{{ $business->personal_description }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .breadcrumb {
            background-color: #f8f9fa;
            padding: 0;
        }

        .breadcrumb-item a {
            color: #81B622;
        }

        .breadcrumb-item a:hover {
            text-decoration: underline;
        }

        .action-buttons {
            justify-content: flex-end;
        }

        .product-image-container {
            position: sticky;
            top: 20px;
        }

        .main-image-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 400px;
        }

        .main-image-wrapper img {
            height: 100%;
            width: 100%;
            object-fit: contain;
        }

        .small-img-col {
            transition: transform 0.2s ease;
        }

        .small-img-col:hover {
            transform: scale(1.05);
        }

        .small-img {
            transition: border 0.2s ease;
            cursor: pointer;
        }

        .small-img:hover {
            border-color: #81B622 !important;
        }

        .product-info h1 {
            color: #333;
            font-size: 2rem;
        }

        .price-section {
            background-color: #f0f0f0;
            padding: 1rem;
            border-radius: 8px;
        }

        .info-item {
            padding: 0.75rem 0;
            border-bottom: 1px solid #eee;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .card-header {
            border-bottom: 2px solid rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .product-image-container {
                position: relative;
                top: 0;
            }

            .main-image-wrapper {
                height: 300px;
            }

            .action-buttons {
                justify-content: flex-start;
                margin-top: 1rem;
            }

            .product-info h1 {
                font-size: 1.5rem;
            }

            .breadcrumb {
                padding: 0.5rem 0;
            }
        }

        @media (max-width: 576px) {
            .main-image-wrapper {
                height: 250px;
            }

            .small-img-col {
                flex: 0 0 calc(25% - 0.5rem) !important;
            }

            .product-info h1 {
                font-size: 1.25rem;
            }

            .action-buttons {
                gap: 0.5rem !important;
            }

            .action-buttons .btn {
                font-size: 0.8rem;
                padding: 0.4rem 0.6rem;
            }
        }
    </style>
@endsection
