<!--Navigation-->

@php
    $front = App\Models\FrontControl::first();
@endphp

<style>
    .navbar {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.2);
        padding: 12px 0 !important;
    }

    .navbar-brand img {
        height: 45px;
        transition: transform 0.3s ease;
    }

    .navbar-brand:hover img {
        transform: scale(1.05);
    }

    .nav-link {
        color: white !important;
        font-weight: 700;
        font-size: 0.95rem;
        margin: 0 8px;
        position: relative;
        transition: all 0.3s ease;
        letter-spacing: 0.5px;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
    }

    .nav-link::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 0;
        height: 2px;
        background: rgba(255, 255, 255, 0.9);
        transition: width 0.3s ease;
    }

    .nav-link:hover::after {
        width: 100%;
    }

    .nav-link:hover {
        color: #fff !important;
        transform: translateY(-2px);
    }

    .nav-link.active,
    .nav-item.active .nav-link {
        color: #28a745 !important;
        background: white;
        border-radius: 999px;
        padding: 8px 14px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        border-bottom: none;
    }

    .nav-link.active::after,
    .nav-item.active .nav-link::after {
        width: 0;
    }

    .dropdown-menu {
        background: linear-gradient(135deg, #20c997 0%, #17a2b8 100%);
        border: none;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        border-radius: 8px;
    }

    .dropdown-item {
        color: white !important;
        font-weight: 500;
        transition: all 0.2s ease;
        border-left: 3px solid transparent;
    }

    .dropdown-item:hover {
        background: rgba(255, 255, 255, 0.2);
        border-left-color: white;
        padding-left: 18px;
    }

    .nav-item i {
        font-size: 1.2rem;
        color: white;
        transition: all 0.3s ease;
    }

    .nav-item i:hover {
        color: #fff;
        transform: scale(1.2);
    }

    .nav-item small {
        background: #e74c3c;
        color: white;
        padding: 2px 6px;
        border-radius: 50%;
        font-weight: 700;
        font-size: 0.7rem;
        margin-left: 5px;
        display: inline-block;
    }

    .search-form {
        display: flex;
        align-items: center;
        margin-left: 15px;
        min-width: 220px;
        max-width: 320px;
    }

    .search-box {
        position: relative;
        width: 100%;
    }

    .search-form input {
        width: 100%;
        background: white !important;
        border: 2px solid white !important;
        color: #2a2a2a !important;
        padding: 10px 46px 10px 16px !important;
        border-radius: 999px !important;
        font-weight: 600;
        transition: width 0.35s ease, box-shadow 0.35s ease;
        min-width: 180px;
        max-width: 280px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.12);
        font-size: 0.95rem;
    }

    .search-form input:focus {
        background: white !important;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.18) !important;
        outline: none;
        width: 100%;
    }

    .search-form input::placeholder {
        color: #777 !important;
        font-weight: 600;
    }

    .search-btn {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: white;
        color: #28a745;
        font-size: 0.95rem;
        cursor: pointer;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.12);
        transition: all 0.3s ease;
        padding: 0;
    }

    .search-btn:hover {
        background: #f8f9fa;
        color: #19692c;
        transform: translateY(-50%) scale(1.05);
    }

    @media (max-width: 991px) {
        .search-form {
            min-width: auto;
            max-width: 220px;
            margin-left: 0;
        }

        .search-form input {
            max-width: 220px;
        }

        .nav-link {
            margin: 5px 0;
            padding: 8px 0;
            border-left: 3px solid transparent;
        }

        .nav-link:hover {
            border-left-color: white;
            padding-left: 10px;
        }
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light fixed-top ">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('img_DB/front/logo/amarkrishiponno.svg') }}" alt="amarkrishiponno">
        </a>

        <button class="navbar-toggler border-white" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="নেভিগেশন">
            <span><i class="fas fa-bars" style="color: white; font-weight: 700;"></i></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
                    <a class="nav-link" aria-current="page" href="{{ url('/') }}">🏠 হোম</a>
                </li>

                <li class="nav-item {{ Request::is('my_business') ? 'active' : '' }}">
                    <a class="nav-link" aria-current="page" href="{{ url('my_business') }}">🛍️ পণ্যসমূহ</a> 
                </li>

                <li class="nav-item {{ Request::is('shop') ? 'active' : '' }}">
                    <a class="nav-link" aria-current="page" href="{{ url('shop') }}">📦 এডমিন পণ্যসমূহ</a>
                </li>

                <li class="nav-item {{ Request::is('top-rated') ? 'active' : '' }}">
                    <a class="nav-link" aria-current="page" href="{{ url('top-rated') }}">⭐ সেরা রেটিং পণ্য</a>
                </li>

                <li class="nav-item {{ Request::is('business_profile') ? 'active' : '' }}">
                    <a class="nav-link" aria-current="page" href="{{ url('business_profile') }}">👔আমার ব্যবসা</a>
                </li>

                <li class="nav-item {{ Request::is('my_orders') ? 'active' : '' }}">
                    <a class="nav-link" aria-current="page" href="{{ url('my_orders') }}">👔আমার অর্ডার</a>
                </li>

                <li class="nav-item {{ Request::is('news') ? 'active' : '' }}">
                    <a class="nav-link" aria-current="page" href="{{ url('news') }}">📰 সংবাদ</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        📄 আরও
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li class="nav-item">
                            <a class="dropdown-item" href="{{ url('contact') }}">📞 যোগাযোগ</a>
                        </li>

                        <li class="nav-item">
                            <a class="dropdown-item" href="{{ url('about') }}">ℹ️ সম্পর্কে</a>
                        </li>
                    </ul>
                </li>

                {{-- count --}}
                @php
                    $quantity = App\Models\Cart::where('user_id', Auth::id())
                        ->where('user_ip', request()->ip())
                        ->sum('qty');
                    $wishqty = App\Models\Wishlist::where('user_id', Auth::id())->where('user_id', Auth::id())->get();
                @endphp

                <li class="nav-item {{ Request::is('cart') ? 'active' : '' }}">
                    <a href="{{ url('cart') }}" class="nav-link" aria-current="page">
                        <i class="fal fa-shopping-bag">
                            <small>{{ $quantity }}</small>
                        </i>
                    </a>
                </li>

                <li class="nav-item {{ Request::is('wishlist') ? 'active' : '' }}">
                    <a href="{{ url('wishlist') }}" class="nav-link" aria-current="page">
                        <i class="fas fa-heart">
                            <small>{{ count($wishqty) }}</small>
                        </i>
                    </a>
                </li>

                <li class="nav-item">
                    <form action="{{ url('search_product_item') }}" method="GET" class="search-form">
                        {{ csrf_field() }}
                        <div class="search-box">
                            <input type="text" name="query" id="query" class="form-control"
                                placeholder="অনুসন্ধান করুন..." autocomplete="off">
                            <button type="submit" class="search-btn" aria-label="search">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </li>
            </ul>

            <div class="d-flex justify-content-end">
                {{-- change --}}
                @if (Route::has('login'))
                    @auth
                        <!--user profile logout-->
                        <x-app-layout>
                        </x-app-layout>
                    @else
                        <a class="nav-link btn login-btn m-1 btn-sm" aria-current="page"
                            href="{{ route('login') }}">Login</a>

                        <a class="nav-link btn login-btn m-1 btn-sm" aria-current="page"
                            href="{{ route('register') }}">Register</a>
                    @endauth
                @endif
            </div>

        </div>
    </div>


</nav>
