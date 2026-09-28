@extends('layouts.frontend_layout')


@section('title')
    AgroBd - Checkout
@endsection

<style>
    .checkout {
        padding: 40px 0;
        background: #f8faf4;
    }

    .checkout__form {
        display: block;
    }

    .checkout-card,
    .checkout-order-card {
        background: #ffffff;
        border: 1px solid #e6efd8;
        border-radius: 16px;
        box-shadow: 0 14px 30px rgba(28, 79, 35, 0.08);
        padding: 28px;
    }

    .checkout-card {
        min-height: 100%;
    }

    .checkout-order-card {
        padding: 26px 24px;
    }

    .checkout__section-title {
        font-size: 1.45rem;
        font-weight: 700;
        color: #1f3a16;
        margin-bottom: 1rem;
    }

    .checkout__subtitle {
        color: #5a6c55;
        font-size: 0.96rem;
        margin-top: 0.25rem;
        display: block;
    }

    .checkout form .form-group label {
        font-size: 0.95rem;
        font-weight: 600;
        color: #33402c;
    }

    .checkout form .form-control {
        border: 1px solid #d7e3cb;
        border-radius: 10px;
        padding: 0.92rem 1rem;
        color: #1f3a16;
        background: #fcfff6;
        box-shadow: none;
    }

    .checkout form .form-control:focus {
        border-color: #81b622;
        box-shadow: 0 0 0 0.15rem rgba(129, 182, 34, 0.18);
    }

    .checkout__order-list {
        border-top: 1px solid #edf4e5;
        margin-top: 1rem;
        padding-top: 1rem;
    }

    .checkout__order-item {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding: 0.85rem 0;
        border-bottom: 1px solid #f2f5ed;
    }

    .checkout__order-item:last-child {
        border-bottom: none;
    }

    .checkout__order-summary {
        margin-top: 1.25rem;
    }

    .checkout__order-summary .d-flex {
        padding: 0.65rem 0;
    }

    .checkout__order-summary strong,
    .checkout__order-item h6 {
        color: #22311c;
    }

    .checkout__payment-title {
        font-size: 1rem;
        font-weight: 700;
        margin-top: 1.35rem;
        color: #2e4721;
    }

    .checkout__input__checkbox label {
        display: block;
        font-size: 0.95rem;
        color: #42523b;
        margin-bottom: 0.75rem;
        cursor: pointer;
    }

    .checkout__input__checkbox input[type="radio"] {
        margin-left: 0.5rem;
        transform: scale(1.05);
    }

    .checkout-btn {
        width: 100%;
        display: inline-flex;
        justify-content: center;
        align-items: center;
        font-size: 0.92rem;
        font-weight: 700;
        border-radius: 10px;
        padding: 14px 18px;
        border: none;
        background-color: #1d1d1d;
        color: #ffffff;
        transition: all 0.25s ease;
        text-transform: uppercase;
    }

    .checkout-btn:hover {
        background-color: #81b622;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .checkout__or-separator {
        text-align: center;
        color: #6b6b6b;
        margin: 1rem 0;
        font-size: 0.92rem;
    }

    .checkout__hint-text {
        font-size: 0.95rem;
        color: #5f6c55;
    }

    .checkout .card {
        background: transparent;
        border: none;
        box-shadow: none;
    }

    @media (max-width: 991px) {
        .checkout-card,
        .checkout-order-card {
            padding: 22px;
        }
    }

    @media (max-width: 576px) {
        .checkout {
            padding: 24px 0;
        }

        .checkout__section-title {
            font-size: 1.3rem;
        }

        .checkout-btn {
            padding: 12px 16px;
        }
    }
</style>


@section('frontend_content')
    <section id="cart-home " class="mt-5  pt-5 container">
        <h2 class="font-weight-bold ">অর্ডার নিশ্চিত করুন</h2>
        <p class="text-muted">আপনার ডেলিভারি তথ্য পূরণ করুন এবং নিরাপদে অর্ডার সম্পন্ন করুন</p>
        <hr>
    </section>


    <!-- Checkout Section Begin -->
    <section class="checkout mb-5">
        <div class="container">

            <div class="checkout__form">

                <form action="{{ url('place_order') }}" method="POST">
                    @csrf

                    <div class="row">


                        <div class="col-lg-8 col-md-6 col-12 mt-4">
                            <h3 class="checkout__section-title">Shipping Address</h3>
                            <span class="checkout__subtitle">This form is for cash-on-delivery orders. Fill in your delivery details to complete the order.</span>
                            <div class="checkout-card mt-3">
                                <div class="row">

                                    <input type="hidden" name="User_id" value="{{ Auth::user()->id }}">

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Name: <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control bg-white " style="color: black" type="text"
                                                name="shipping_name" placeholder="name" value="{{ Auth::user()->name }}"
                                                readonly>
                                            @error('shipping_name')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Email: <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control bg-white " style="color: black" type="text"
                                                name="shipping_email" placeholder="email" value="{{ Auth::user()->email }}"
                                                readonly>
                                            @error('shipping_email')
                                                <strong class="text-danger">{{ $message }}</strong>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Phone:<span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control bg-white " style="color: black" type="text"
                                                name="shipping_phone" placeholder="phone" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Address: <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control bg-white " style="color: black" type="text"
                                                name="address" placeholder="address" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Country/State: <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control bg-white " style="color: black" type="text"
                                                name="state" placeholder="country/state" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label">Zip Code: <span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control bg-white " style="color: black" type="text"
                                                name="post_code" placeholder="zip code (integer type)" required>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Something write about shopping if any
                                                (optional):</label>
                                            <textarea style="color:black" rows="3" name="description" class="form-control bg-white " id="exampleInputEmail1"
                                                cols="5"></textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="col-lg-4 col-md-6 col-12 mt-4">

                            <div class="checkout__order">
                                <h3 class="checkout__section-title">My Order</h3>

                                <div class="checkout-order-card">
                                    <div class="checkout__order-list">
                                        @foreach ($carts as $cart)
                                            <div class="checkout__order-item">
                                                <h6 class="mb-0">{{ $cart->product->product_name }} ({{ $cart->qty }})</h6>
                                                <p class="mb-0 text-dark">{{ $cart->price * $cart->qty }} TK</p>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="checkout__order-summary">
                                        @if (Session::has('discount'))
                                            <div class="d-flex justify-content-between">
                                                <span>Subtotal</span>
                                                <span>{{ $subtotal }} TK</span>
                                            </div>

                                            <div class="d-flex justify-content-between">
                                                <span>Discount</span>
                                                <span>{{ session()->get('discount')['discount_percentage'] }}% ({{ session()->get('discount')['discount_amount'] }} TK)</span>
                                            </div>

                                            <div class="d-flex justify-content-between">
                                                <strong>Total</strong>
                                                <strong>{{ $subtotal - session()->get('discount')['discount_amount'] }} TK</strong>
                                            </div>
                                            <input type="hidden" name="discount_percentage" value="{{ session()->get('discount')['discount_percentage'] }}">
                                            <input type="hidden" name="subtotal" value="{{ $subtotal }}">
                                            <input type="hidden" name="total" value="{{ $subtotal - session()->get('discount')['discount_amount'] }}">
                                        @else
                                            <div class="d-flex justify-content-between">
                                                <strong>Total</strong>
                                                <strong>{{ $subtotal }} TK</strong>
                                            </div>
                                            <input type="hidden" name="subtotal" value="{{ $subtotal }}">
                                            <input type="hidden" name="total" value="{{ $subtotal }}">
                                        @endif
                                    </div>

                                    <p class="checkout__payment-title">Select Payment Method</p>

                                    <div class="checkout__input__checkbox mb-3">
                                        <label for="payment">
                                            <input type="radio" value="HandCash" name="payment_type" required>
                                            <span> HansCash</span>
                                        </label>
                                        @error('payment_type')
                                            <span class="text-danger d-block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="checkout-btn mb-2">Place Order (Hand Cash)</button>
                                    <div class="checkout__or-separator">OR</div>
                                    <a href="{{ url('example2') }}" class="checkout-btn text-white">Online Payment</a>

                                </div>

                            </div>

                        </div>
                    </div>

                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->
@endsection
