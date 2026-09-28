@extends('layouts.frontend_layout')


@section('title')
    AgroBd - Contact
@endsection


@php
    $front = App\Models\FrontControl::first();
@endphp


@section('frontend_content')
    <!--banner-->
    <section id="banner" class="mt-5"
        style=" background-image: url({{ asset('img_DB/front/contact_banner/' . $front->contact_banner_img) }});  height: 60vh !important;">
    </section>

    <section id="cart-home " class="mb-5 pt-5 container ">
        <h2 class="font-weight-bold text-center">আমাদের সাথে যোগাযোগ করুন</h2>
        <p class="text-center text-muted mt-3">আপনার যে কোন প্রশ্ন বা পরামর্শের জন্য আমাদের কাছে পৌঁছান। Amar-Krishiponno টিম সবসময় আপনার সেবায় নিয়োজিত।</p>
    </section>

    <section class=" mb-5 pb-5">
        <div class="w-50 mx-auto">
            <form class="main-form" action="{{ url('contact_submit') }}" method="POST">
                @csrf

                <div class="row mt-5">
                    <div class="col-12 col-sm-6 py-2 wow fadeInLeft">
                        <input type="text" name="name" class="form-control" placeholder="পূর্ণ নাম" required>
                    </div>

                    <div class="col-12 col-sm-6 py-2 wow fadeInRight">
                        <input type="text" name="email" class="form-control" placeholder="ইমেইল ঠিকানা" required>
                    </div>

                    <div class="col-12 col-sm-6 py-2 wow fadeInLeft" data-wow-delay="300ms">
                        <input type="date" name="date" class="form-control" required>
                    </div>

                    <div class="col-12 col-sm-6 py-2 wow fadeInUp" data-wow-delay="300ms">
                        <input type="text" name="phone" class="form-control" placeholder="ফোন নম্বর" required>
                    </div>

                    <div class="col-12 py-2 wow fadeInUp" data-wow-delay="300ms">
                        <textarea name="message" id="message" class="form-control" rows="6" placeholder="আপনার বার্তা লিখুন..."
                            required></textarea>
                    </div>

                </div>

                <button type="submit" class="btn mt-3 wow zoomIn text-white">যোগাযোগ জমা দিন</button>
            </form>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <h3 class="text-center fw-bold mb-5">কেন Amar-Krishiponno-এর সাথে যোগাযোগ করবেন?</h3>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm text-center" style="border-top: 4px solid #28a745;">
                        <div class="card-body p-4">
                            <h5 style="font-size: 2rem; margin-bottom: 15px;">🤝</h5>
                            <h5 class="card-title fw-bold">কৃষক সহায়তা</h5>
                            <p class="card-text text-muted">আপনি যদি একজন কৃষক বা ছোট ব্যবসায়ী হন, আমরা আপনাকে আমাদের প্ল্যাটফর্মে যুক্ত হতে সাহায্য করতে পারি।</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm text-center" style="border-top: 4px solid #20c997;">
                        <div class="card-body p-4">
                            <h5 style="font-size: 2rem; margin-bottom: 15px;">💬</h5>
                            <h5 class="card-title fw-bold">গ্রাহক সেবা</h5>
                            <p class="card-text text-muted">আপনার অর্ডার সম্পর্কে কোন প্রশ্ন বা সমস্যা থাকলে আমাদের টিম সর্বদা সাহায্যের জন্য প্রস্তুত।</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm text-center" style="border-top: 4px solid #ffc107;">
                        <div class="card-body p-4">
                            <h5 style="font-size: 2rem; margin-bottom: 15px;">📋</h5>
                            <h5 class="card-title fw-bold">সাধারণ প্রশ্ন</h5>
                            <p class="card-text text-muted">আমাদের প্ল্যাটফর্ম, ডেলিভারি, পেমেন্ট সম্পর্কে যেকোনো প্রশ্ন জানাতে পারেন।</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
