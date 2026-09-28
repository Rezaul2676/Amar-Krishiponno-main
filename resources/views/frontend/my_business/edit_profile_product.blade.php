@extends('layouts.frontend_layout')


@section('title')
    AgroBd - Edit Product Business
@endsection


@section('frontend_content')
    <section id="cart-home " class="mt-5  pt-5 container">
        <h2 class="font-weight-bold "> Edit Product Business</h2>
        <hr>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Validation Errors:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </section>

    <section class="Business mb-5">
        <div class="container">

            <form action="{{ url('add_business_update/' . $business->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    <div class="col-lg-12 col-md-12 col-12 mt-4">

                        <div class="card p-3" style="background:#bada7f">
                            <div class="row">

                                <h3 class="my-3"><strong>Edit My Business</strong> </h3>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Product Name: <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control bg-white " style="color: black" type="text"
                                            name="product_name" placeholder="product name"
                                            value="{{ $business->product_name }}" required>

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Product Category: <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control bg-white " style="color: black" type="text"
                                            name="category" placeholder="product category" value="{{ $business->category }}"
                                            required>

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Product Quantity:<span
                                                class="text-danger">*</span></label>
                                        <input class="form-control bg-white " style="color: black" type="text"
                                            name="product_quantity" placeholder="product quantity"
                                            value="{{ $business->product_quantity }}" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Product Price: <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control bg-white " style="color: black" type="text"
                                            name="price" placeholder="price" value="{{ $business->price }}" required>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Product Description</label>
                                        <textarea style="color:black" rows="3" name="product_description" class="form-control bg-white "
                                            id="exampleInputEmail1" cols="5" required>{{ $business->product_description }}"</textarea>
                                    </div>
                                </div>


                                <div class="row row-sm mt-5">

                                    <div class="col-lg-3 col-md-6 my-2">
                                        <div class="form-group">
                                            <label class="form-control-label">Main thambnail: <span
                                                    class="text-danger">*</span></label>
                                            <img src="{{ asset('img_DB/my_business/image_one/' . $business->image_one) }}"
                                                alt="" height="120px;" width="120px;">
                                        </div>
                                        <div class="form-group my-1">
                                            <input class="form-control" type="file" name="image_one">
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 my-2">
                                        <div class="form-group">
                                            <label class="form-control-label">Image Two: <span
                                                    class="text-danger">*</span></label>
                                            <img src="{{ asset('img_DB/my_business/image_two/' . $business->image_two) }}"
                                                alt="" height="120px;" width="120px;">
                                        </div>
                                        <div class="form-group my-1">
                                            <input class="form-control" type="file" name="image_two">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 my-2">
                                        <div class="form-group">
                                            <label class="form-control-label">Image Three: <span
                                                    class="text-danger">*</span></label>
                                            <img src="{{ asset('img_DB/my_business/image_three/' . $business->image_three) }}"
                                                alt="" height="120px;" width="120px;">
                                        </div>
                                        <div class="form-group my-1">
                                            <input class="form-control" type="file" name="image_three">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 my-2">
                                        <div class="form-group">
                                            <label class="form-control-label">Image Four: <span
                                                    class="text-danger">*</span></label>
                                            <img src="{{ asset('img_DB/my_business/image_four/' . $business->image_four) }}"
                                                alt="" height="120px;" width="120px;">
                                        </div>
                                        <div class="form-group my-1">
                                            <input class="form-control" type="file" name="image_four">
                                        </div>
                                    </div>


                                </div>


                            </div>
                        </div>

                    </div>

                    <div class="col-lg-12 col-md-12 col-12 mt-4">
                        <div class="card p-3" style="background:#bada7f">
                            <div class="row">

                                <h3 class="my-3"><strong>Address Of The Selling Place</strong> </h3>

                                <input type="hidden" name="User_id" value="{{ Auth::user()->id }}">

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Name: <span class="text-danger">*</span></label>
                                        <input class="form-control bg-white " style="color: black" type="text"
                                            name="name" placeholder="name" value="{{ Auth::user()->name }}" readonly>

                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Email: <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control bg-white " style="color: black" type="text"
                                            name="email" placeholder="email" value="{{ Auth::user()->email }}"
                                            readonly>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Phone:<span class="text-danger">*</span></label>
                                        <input class="form-control bg-white " style="color: black" type="text"
                                            name="phone" placeholder="phone" value="{{ Auth::user()->phone }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Village/House: <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control bg-white " style="color: black" type="text"
                                            name="village" placeholder="village/house" value="{{ $business->village }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Road/Block/Sector: <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control bg-white " style="color: black" type="text"
                                            name="road" placeholder="road/block/sector" value="{{ $business->road }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Police Station: <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control bg-white " style="color: black" type="text"
                                            name="police_station" placeholder="police station"
                                            value="{{ $business->police_station }}" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Post Office: <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control bg-white " style="color: black" type="text"
                                            name="post_office" placeholder="post office"
                                            value="{{ $business->post_office }}" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">District: <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control bg-white " style="color: black" type="text"
                                            name="district" placeholder="district" value="{{ $business->district }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Post Code: <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control bg-white " style="color: black" type="text"
                                            name="post_code" placeholder="post code (integer type)"
                                            value="{{ $business->post_code }}" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Country: <span
                                                class="text-danger">*</span></label>
                                        <input class="form-control bg-white " style="color: black" type="text"
                                            name="country" placeholder="country" value="{{ $business->country }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Something write about your address if any
                                            (optional):</label>
                                        <textarea style="color:black" rows="3" name="personal_description" class="form-control bg-white "
                                            id="exampleInputEmail1" cols="5"> {{ $business->personal_description }}"</textarea>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="col-lg-12 col-md-12 col-12 mt-4">
                        <div class="card p-3" style="background:#bada7f">
                            <div class="row">

                                <h3 class="my-3"><strong>Payment Settings</strong> </h3>

                                <div
                                    style="background: white; padding: 12px; border-radius: 5px; margin-bottom: 15px; border-left: 4px solid #81B622;">
                                    <p style="margin: 0; font-size: 14px; color: #666;">
                                        <i class="fas fa-info-circle"></i> <strong>Important:</strong> After changing
                                        payment settings, make sure to scroll down and click the <strong>UPDATE</strong>
                                        button to save your changes.
                                    </p>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label">Payment Gateway: <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control bg-white" style="color: black" name="payment_gateway"
                                            required>
                                            <option value="sslcommerz"
                                                {{ $business->payment_gateway == 'sslcommerz' ? 'selected' : '' }}>
                                                SSLCommerz</option>
                                            <option value="bkash"
                                                {{ $business->payment_gateway == 'bkash' ? 'selected' : '' }}>bKash
                                            </option>
                                            <option value="bank"
                                                {{ $business->payment_gateway == 'bank' ? 'selected' : '' }}>Bank Transfer
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6 sslcommerz-fields">
                                    <div class="form-group">
                                        <label class="form-control-label">SSLCommerz Store ID:</label>
                                        <input class="form-control bg-white " style="color: black" type="text"
                                            name="store_id" value="{{ $business->store_id }}">
                                    </div>
                                </div>

                                <div class="col-lg-6 sslcommerz-fields">
                                    <div class="form-group">
                                        <label class="form-control-label">SSLCommerz Store Password:</label>
                                        <input class="form-control bg-white " style="color: black" type="password"
                                            name="store_password" value="{{ $business->store_password }}">
                                    </div>
                                </div>

                                <div class="col-lg-6 bkash-fields" style="display: none;">
                                    <div class="form-group">
                                        <label class="form-control-label">bKash Number:</label>
                                        <input class="form-control bg-white " style="color: black" type="text"
                                            name="bkash_number" value="{{ $business->bkash_number }}">
                                    </div>
                                </div>

                                <div class="col-lg-6 bank-fields" style="display: none;">
                                    <div class="form-group">
                                        <label class="form-control-label">Bank Name:</label>
                                        <input class="form-control bg-white " style="color: black" type="text"
                                            name="bank_name" value="{{ $business->bank_name }}">
                                    </div>
                                </div>

                                <div class="col-lg-6 bank-fields" style="display: none;">
                                    <div class="form-group">
                                        <label class="form-control-label">Account Number:</label>
                                        <input class="form-control bg-white " style="color: black" type="text"
                                            name="bank_account" value="{{ $business->bank_account }}">
                                    </div>
                                </div>

                                <div class="col-lg-6 bank-fields" style="display: none;">
                                    <div class="form-group">
                                        <label class="form-control-label">Routing Number:</label>
                                        <input class="form-control bg-white " style="color: black" type="text"
                                            name="bank_routing" value="{{ $business->bank_routing }}">
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>


                <button type="submit" class="buy-btn button-style ml-2 mt-2">Update</button>
            </form>

        </div>
    </section>
    <!-- Checkout Section End -->
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var gatewaySelect = document.querySelector('select[name="payment_gateway"]');
            var sslFields = document.querySelectorAll('.sslcommerz-fields');
            var bkashFields = document.querySelectorAll('.bkash-fields');
            var bankFields = document.querySelectorAll('.bank-fields');

            function toggleFields() {
                var gateway = gatewaySelect.value;
                sslFields.forEach(function(el) {
                    el.style.display = 'none';
                });
                bkashFields.forEach(function(el) {
                    el.style.display = 'none';
                });
                bankFields.forEach(function(el) {
                    el.style.display = 'none';
                });

                if (gateway === 'sslcommerz') {
                    sslFields.forEach(function(el) {
                        el.style.display = 'block';
                    });
                } else if (gateway === 'bkash') {
                    bkashFields.forEach(function(el) {
                        el.style.display = 'block';
                    });
                } else if (gateway === 'bank') {
                    bankFields.forEach(function(el) {
                        el.style.display = 'block';
                    });
                }
            }

            if (gatewaySelect) {
                gatewaySelect.addEventListener('change', toggleFields);
                toggleFields();
            }
        });
    </script>
@endsection
