@extends('layouts.frontend_layout')


@section('title')
AgroBd - About Us
@endsection

@php
    $front = App\Models\FrontControl::first();
@endphp


@section('frontend_content')

    <!--banner-->
    <section id="banner" class="mt-5"
        style=" background-image: url({{ asset('img_DB/front/about_banner/' . $front->about_banner_img) }});  height: 60vh;">
    </section>

    <section id="cart-home " class="mt-5 container">
        <h2 class="font-weight-bold text-center mb-3">Amar-krishiponno সম্পর্কে জানুন</h2>
        <p class="text-center text-muted">বাংলাদেশের কৃষি ক্ষেত্রে একটি বিপ্লবী পরিবর্তন আনতে আমরা প্রতিশ্রুতিবদ্ধ</p>
    </section>

    <section class="container mt-5">
        <div class="row">
            <div class="col-lg-8 col-12 mx-auto">
                <h4 class="mb-3 text-success fw-bold">🌾 আমাদের মিশন</h4>
                <p class="text" style="line-height: 1.8; font-size: 1.05rem;">
                    Amar-krishiponno হল বাংলাদেশের একটি অগ্রণী কৃষি ই-কমার্স প্ল্যাটফর্ম যা কৃষক এবং ক্রেতাদের মধ্যে সরাসরি সংযোগ স্থাপন করে। আমরা বিশ্বাস করি যে প্রযুক্তির মাধ্যমে আমরা স্থানীয় কৃষিকে আরও শক্তিশালী এবং লাভজনক করতে পারি। আমাদের লক্ষ্য হল প্রতিটি বাংলাদেশী পরিবারে সতেজ এবং প্রাকৃতিক কৃষি পণ্য পৌঁছে দেওয়া, যা সরাসরি খামার থেকে আপনার দরজায় আসে।
                    <span class="more-text" style="display: none;">
                        <br><br>আমরা কৃষকদের ন্যায্য মূল্য প্রদান করি এবং গ্রাহকদের সর্বোচ্চ মানের পণ্য নিশ্চিত করি। আমাদের প্ল্যাটফর্মে রয়েছে চাল, গম, সবজি, ফল, মসলা, দুধ, ডিম এবং আরও অনেক কৃষিজাত পণ্য। প্রতিটি পণ্য যাচাই-বাছাই করা হয় এবং খামার থেকে প্যাকেজিং পর্যন্ত সর্বোচ্চ মান বজায় রাখা হয়। AgroBd শুধুমাত্র একটি অনলাইন দোকান নয়, এটি একটি সম্প্রদায় যেখানে কৃষক এবং ভোক্তারা একসাথে কাজ করে একটি উন্নত বাংলাদেশ গড়তে।
                    </span>
                </p>
                <button class="read-more-btn btn btn-success">আরও পড়ুন</button>
            </div>
        </div>
    </section>

    <section class="container my-5 py-5">
        <h4 class="text-center fw-bold mb-5" style="font-size: 1.8rem;">🎯 আমাদের মূল মূল্যবোধ</h4>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100 shadow-sm border-0" style="border-top: 4px solid #28a745; border-radius: 12px;">
                    <div class="card-body text-center p-4">
                        <h5 style="font-size: 2.5rem; margin-bottom: 15px;">🌾</h5>
                        <h5 class="card-title fw-bold text-success">স্থানীয় কৃষি সমর্থন</h5>
                        <p class="card-text text-muted">আমরা শুধুমাত্র বাংলাদেশী কৃষকদের পণ্য বিক্রয় করি, যা আমাদের সম্প্রদায়কে সমর্থন করে এবং স্থানীয় অর্থনীতি শক্তিশালী করে।</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100 shadow-sm border-0" style="border-top: 4px solid #20c997; border-radius: 12px;">
                    <div class="card-body text-center p-4">
                        <h5 style="font-size: 2.5rem; margin-bottom: 15px;">🚚</h5>
                        <h5 class="card-title fw-bold text-info">দ্রুত ও নিরাপদ ডেলিভারি</h5>
                        <p class="card-text text-muted">সারাদেশে দ্রুত এবং নিরাপদ ডেলিভারি সেবা নিশ্চিত করি যাতে আপনার কৃষিপণ্য তাজা অবস্থায় পৌঁছায়।</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100 shadow-sm border-0" style="border-top: 4px solid #ffc107; border-radius: 12px;">
                    <div class="card-body text-center p-4">
                        <h5 style="font-size: 2.5rem; margin-bottom: 15px;">✅</h5>
                        <h5 class="card-title fw-bold text-warning">কঠোর মান নিয়ন্ত্রণ</h5>
                        <p class="card-text text-muted">প্রতিটি পণ্য সাবধানে নির্বাচিত এবং পরীক্ষিত যাতে আপনি শুধুমাত্র সেরা মানের পণ্য পান।</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100 shadow-sm border-0" style="border-top: 4px solid #dc3545; border-radius: 12px;">
                    <div class="card-body text-center p-4">
                        <h5 style="font-size: 2.5rem; margin-bottom: 15px;">💚</h5>
                        <h5 class="card-title fw-bold text-danger">পরিবেশ বান্ধব</h5>
                        <p class="card-text text-muted">আমরা জৈব এবং প্রাকৃতিক কৃষি পদ্ধতিকে উৎসাহিত করি এবং টেকসই কৃষিকে সমর্থন করি।</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-light py-5 my-5">
        <div class="container">
            <h4 class="text-center fw-bold mb-5" style="font-size: 1.8rem;">📊 আমাদের অর্জন</h4>
            <div class="row text-center">
                <div class="col-lg-3 col-md-6 mb-4">
                    <h3 class="fw-bold text-success" style="font-size: 2.5rem;">৫০০০+</h3>
                    <p class="text-muted">সক্রিয় কৃষক ও বিক্রেতা</p>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h3 class="fw-bold text-info" style="font-size: 2.5rem;">৩০০০০+</h3>
                    <p class="text-muted">সন্তুষ্ট গ্রাহক</p>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h3 class="fw-bold text-warning" style="font-size: 2.5rem;">৬৪</h3>
                    <p class="text-muted">জেলায় পরিষেবা</p>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h3 class="fw-bold text-danger" style="font-size: 2.5rem;">১০০০০+</h3>
                    <p class="text-muted">বিভিন্ন পণ্য</p>
                </div>
            </div>
        </div>
    </section>



    <section class="py-5 my-5 bg-success text-white rounded-3" style="margin-left: 15px; margin-right: 15px;">
        <div class="container text-center">
            <h4 class="fw-bold mb-3" style="font-size: 1.5rem;">🌱 আমাদের সাথে যোগ দিন</h4>
            <p style="font-size: 1.1rem; margin-bottom: 20px;">আপনি কৃষক হন বা ক্রেতা, AgroBd আপনার জন্য সর্বোত্তম সমাধান নিয়ে আসছে। আমাদের সাথে থেকে একটি সমৃদ্ধ ভবিষ্যৎ গড়ুন।</p>
            <a href="{{ url('/') }}" class="btn btn-light fw-bold px-5 py-2">এখনই শুরু করুন</a>
        </div>
    </section>

@endsection
