@php
    $front = App\Models\FrontControl::first();
    $categories = App\Models\Category::where('status', 1)->take(8)->get();
@endphp

<style>
    footer {
        background: linear-gradient(180deg, #0c4e28 0%, #187940 100%);
        color: rgba(255, 255, 255, 0.95);
        position: relative;
        overflow: hidden;
    }

    footer::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top left, rgba(255, 255, 255, 0.1), transparent 25%),
            radial-gradient(circle at bottom right, rgba(255, 255, 255, 0.08), transparent 22%);
        pointer-events: none;
    }

    .footer-content {
        position: relative;
        z-index: 1;
        padding: 50px 0 20px;
    }

    .footer-one {
        padding: 0;
        margin-bottom: 24px;
    }

    .footer-one h5 {
        font-weight: 800;
        font-size: 1.18rem;
        margin-bottom: 18px;
        color: #f4fdf4;
        position: relative;
        padding-bottom: 10px;
    }

    .footer-one h5::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 48px;
        height: 3px;
        background: #ffffff;
        border-radius: 3px;
    }

    .footer-one p,
    .footer-one li,
    .footer-one h6,
    .copyright p {
        color: rgba(255, 255, 255, 0.92);
    }

    .footer-one p {
        line-height: 1.85;
        font-weight: 500;
        font-size: 0.95rem;
    }

    .footer-one ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-one ul li {
        margin-bottom: 10px;
    }

    .footer-one ul li a {
        color: rgba(255, 255, 255, 0.9);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.95rem;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.25s ease;
        padding: 6px 0;
    }

    .footer-one ul li a:hover {
        color: #dff8dd;
        transform: translateX(4px);
    }

    .footer-one h6 {
        font-weight: 700;
        font-size: 0.96rem;
        margin-top: 18px;
        margin-bottom: 8px;
        letter-spacing: 0.4px;
    }

    .footer-box {
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 20px;
        padding: 28px;
        min-height: 280px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        backdrop-filter: blur(10px);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .footer-box:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.14);
    }

    .footer-box img {
        max-width: 100%;
        border-radius: 14px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .footer-item-images {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
        margin-top: 12px;
    }

    .footer-item-images img {
        width: 100%;
        height: 80px;
        object-fit: cover;
        border-radius: 14px;
    }

    .footer-contact-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 14px;
    }

    .footer-contact-item span {
        min-width: 30px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.05rem;
        color: #a3f5b7;
    }

    .footer-contact-item p {
        margin: 0;
        font-size: 0.95rem;
        line-height: 1.7;
    }

    .footer-brand p {
        margin-top: 18px;
        max-width: 280px;
    }

    .copyright {
        background: rgba(0, 0, 0, 0.14);
        padding: 24px 0;
        border-top: 1px solid rgba(255, 255, 255, 0.12);
        margin-top: 30px;
    }

    .copyright-row {
        align-items: center;
    }

    .copyright p {
        color: rgba(255, 255, 255, 0.88);
        font-weight: 500;
        margin: 0;
        font-size: 0.95rem;
    }

    .copyright a {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        background: rgba(255, 255, 255, 0.12);
        color: white;
        border-radius: 50%;
        margin: 0 4px;
        transition: all 0.25s ease;
        font-size: 1rem;
    }

    .copyright a:hover {
        background: rgba(255, 255, 255, 0.24);
        transform: translateY(-2px);
    }

    @media (max-width: 992px) {
        .footer-box {
            padding: 22px;
        }

        .footer-one {
            margin-bottom: 24px;
        }
    }

    @media (max-width: 768px) {
        .footer-content {
            padding: 40px 0 15px;
        }

        .footer-item-images {
            grid-template-columns: 1fr;
        }
    }
</style>

<footer class="pb-3">
    <div class="footer-content">
        <div class="row container mx-auto pt-5">

            <div class="footer-one col-lg-3 col-md-6 col-12">
                <div class="footer-box footer-brand">
                    <img src="{{ asset('img_DB/front/logo/amarkrishiponno.svg') }}" alt="AgroBd">
                    <p class="pt-3">
                        <strong>AgroBd</strong> - বাংলাদেশের সবচেয়ে বিশ্বস্ত কৃষি পণ্যের অনলাইন মার্কেটপ্লেস। আমরা কৃষক
                        এবং ভোক্তাদের সরাসরি সংযোগ করি, ন্যায্য মূল্য নিশ্চিত করি এবং গুণমান বজায় রাখি।
                    </p>
                </div>
            </div>

            <div class="footer-one col-lg-3 col-md-6 col-12 mb-3">
                <div class="footer-box">
                    <h5>🌾 শীর্ষ পণ্য সমূহ</h5>
                    <ul>
                        @foreach ($categories as $row)
                            <li>
                                <a href="{{ url('category_product_show/' . $row->id) }}">
                                    📦 {{ $row->category_name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="footer-one col-lg-3 col-md-6 col-12 mb-3">
                <div class="footer-box">
                    <h5>📞 আমাদের সাথে যোগাযোগ করুন</h5>

                    <div class="footer-contact-item">
                        <span>📍</span>
                        <p>{{ $front->footer_contact_address }}</p>
                    </div>

                    <div class="footer-contact-item">
                        <span>📱</span>
                        <p>{{ $front->footer_contact_phone }}</p>
                    </div>

                    <div class="footer-contact-item">
                        <span>✉️</span>
                        <p class="text-lowercase">{{ $front->footer_contact_email }}</p>
                    </div>
                </div>
            </div>

            <div class="footer-one col-lg-3 col-md-6 col-12">
                <div class="footer-box">
                    <h5>🎯 আমাদের পণ্য</h5>
                    @php
                        $footerItems = App\Models\Business\MyBusiness::where('status', 1)
                            ->whereNotNull('image_one')
                            ->where('image_one', '!=', '')
                            ->latest()
                            ->take(6)
                            ->get();
                        $fallbackCount = 6 - $footerItems->count();
                    @endphp
                    <div class="footer-item-images">
                        @foreach ($footerItems as $item)
                            <img src="{{ asset('img_DB/my_business/image_one/' . $item->image_one) }}"
                                alt="{{ $item->product_name }}">
                        @endforeach

                        @for ($i = 1; $i <= $fallbackCount; $i++)
                            @php $index = $footerItems->count() + $i; @endphp
                            @php $fieldName = 'footer_iteam_img_' . $index; @endphp
                            @if (!empty($front->{$fieldName}))
                                <img src="{{ asset('img_DB/front/footer_iteam/item' . $index . '/' . $front->{$fieldName}) }}"
                                    alt="Footer image">
                            @endif
                        @endfor
                    </div>
                </div>
            </div>

        </div>

        <div class="copyright">
            <div class="row container mx-auto">

                <div class="col-lg-6 col-12 text-center text-lg-start mb-2">
                    <p>🇧🇩 AgroBd © ২০২৬। সর্বাধিকার সংরক্ষিত | বাংলাদেশের জন্য গর্বের সাথে তৈরি</p>
                </div>

                <div class="col-lg-6 col-12 text-center">
                    <a href="{{ $front->footer_social_fb }}" target="_blank" title="ফেসবুক">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="{{ $front->footer_social_twitter }}" target="_blank" title="টুইটার">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="{{ $front->footer_social_linkedin }}" target="_blank" title="লিংকডইন">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="{{ $front->footer_social_insta }}" target="_blank" title="ইনস্টাগ্রাম">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>

            </div>
        </div>
    </div>
</footer>
