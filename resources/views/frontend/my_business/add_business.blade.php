@extends('layouts.frontend_layout')


@section('title')
    AgroBd - পণ্য যোগ করুন
@endsection


@section('frontend_content')
    <section id="add-product-page" class="mt-5 pt-5 pb-5">
        <div class="container">
            <!-- Page Header -->
            <div class="page-header mb-5">
                <div class="header-content">
                    <h1 class="page-title">🌾 পণ্য যোগ করুন</h1>
                    <p class="page-subtitle">আপনার পণ্যের তথ্য প্রদান করুন এবং বাজারে যুক্ত করুন</p>
                </div>
            </div>

            <form action="{{ url('add_business_store') }}" method="POST" enctype="multipart/form-data"
                class="add-product-form">
                @csrf

                <!-- Product Information Section -->
                <div class="form-section">
                    <div class="section-header">
                        <h2 class="section-title"><i class="fas fa-box"></i> পণ্যের তথ্য</h2>
                        <p class="section-subtitle">পণ্যের নাম, বিভাগ এবং মূল্য সম্পর্কিত তথ্য</p>
                    </div>

                    <div class="form-card">
                        <div class="row g-4">
                            <!-- Product Name -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">পণ্যের নাম <span class="required">*</span></label>
                                    <input class="form-control form-input" type="text" name="product_name"
                                        placeholder="যেমন: আলু, চাউল, সবজি" required>
                                    <small class="help-text">আপনার পণ্যের সঠিক নাম লিখুন</small>
                                </div>
                            </div>

                            <!-- Product Category -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">পণ্যের বিভাগ <span class="required">*</span></label>
                                    <input class="form-control form-input" type="text" name="category"
                                        placeholder="যেমন: সবজি, ফল, শস্য" required>
                                    <small class="help-text">পণ্য কোন বিভাগে পড়ে</small>
                                </div>
                            </div>

                            <!-- Product Quantity -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">পণ্যের পরিমাণ (কেজি)</label>
                                    <input class="form-control form-input" type="number" name="product_quantity"
                                        placeholder="যেমন: 100">
                                    <small class="help-text">মোট পরিমাণ উল্লেখ করুন</small>
                                </div>
                            </div>

                            <!-- Product Price -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">দাম (টাকা) </label>
                                    <input class="form-control form-input" type="number" name="price"
                                        placeholder="যেমন: 500">
                                    <small class="help-text">দাম টাকায়</small>
                                </div>
                            </div>

                            <!-- Product Description -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">পণ্যের বিবরণ</label>
                                    <textarea class="form-control form-textarea" rows="4" name="product_description"
                                        placeholder="পণ্যের গুণমান, উৎপত্তি, বিশেষত্ব ইত্যাদি লিখুন..." required></textarea>
                                    <small class="help-text">বিস্তারিত তথ্য দিন যাতে ক্রেতারা আগ্রহী হন</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Images Section -->
                <div class="form-section mt-5">
                    <div class="section-header">
                        <h2 class="section-title"><i class="fas fa-images"></i> পণ্যের ছবি</h2>
                        <p class="section-subtitle">স্পষ্ট এবং আকর্ষণীয় ছবি যোগ করুন</p>
                    </div>

                    <div class="form-card">
                        <div class="row g-4">
                            <!-- Image 1 -->
                            <div class="col-lg-3 col-md-6">
                                <div class="image-upload-group">
                                    <label class="form-label">প্রধান ছবি <span class="required">*</span></label>
                                    <div class="image-preview-box" id="preview-1">
                                        <i class="fas fa-image"></i>
                                        <p>ছবি নির্বাচন করুন</p>
                                    </div>
                                    <input type="file" name="image_one" class="image-input" accept="image/*" required
                                        onchange="loadFile(event, 'preview-1')">
                                </div>
                            </div>

                            <!-- Image 2 -->
                            <div class="col-lg-3 col-md-6">
                                <div class="image-upload-group">
                                    <label class="form-label">ছবি - ২ <span class="required">*</span></label>
                                    <div class="image-preview-box" id="preview-2">
                                        <i class="fas fa-image"></i>
                                        <p>ছবি নির্বাচন করুন</p>
                                    </div>
                                    <input type="file" name="image_two" class="image-input" accept="image/*" required
                                        onchange="loadFile(event, 'preview-2')">
                                </div>
                            </div>

                            <!-- Image 3 -->
                            <div class="col-lg-3 col-md-6">
                                <div class="image-upload-group">
                                    <label class="form-label">ছবি - ৩ <span class="required">*</span></label>
                                    <div class="image-preview-box" id="preview-3">
                                        <i class="fas fa-image"></i>
                                        <p>ছবি নির্বাচন করুন</p>
                                    </div>
                                    <input type="file" name="image_three" class="image-input" accept="image/*"
                                        required onchange="loadFile(event, 'preview-3')">
                                </div>
                            </div>

                            <!-- Image 4 -->
                            <div class="col-lg-3 col-md-6">
                                <div class="image-upload-group">
                                    <label class="form-label">ছবি - ৪ <span class="required">*</span></label>
                                    <div class="image-preview-box" id="preview-4">
                                        <i class="fas fa-image"></i>
                                        <p>ছবি নির্বাচন করুন</p>
                                    </div>
                                    <input type="file" name="image_four" class="image-input" accept="image/*"
                                        required onchange="loadFile(event, 'preview-4')">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Information Section -->
                <div class="form-section mt-5">
                    <div class="section-header">
                        <h2 class="section-title"><i class="fas fa-map-marker-alt"></i> বিক্রয় স্থানের ঠিকানা</h2>
                        <p class="section-subtitle">আপনার পণ্য যেখান থেকে পাওয়া যায় সেই স্থানের তথ্য</p>
                    </div>

                    <div class="form-card">
                        <input type="hidden" name="User_id" value="{{ Auth::user()->id }}">

                        <div class="row g-4">
                            <!-- Name -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">নাম</label>
                                    <input class="form-control form-input" type="text" name="name"
                                        value="{{ Auth::user()->name }}" readonly>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">ইমেইল</label>
                                    <input class="form-control form-input" type="text" name="email"
                                        value="{{ Auth::user()->email }}" readonly>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">ফোন নম্বর <span class="required">*</span></label>
                                    <input class="form-control form-input" type="text" name="phone"
                                        placeholder="যেমন: 01712345678" value="{{ Auth::user()->phone }}" required>
                                </div>
                            </div>

                            <!-- Village/House -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">গ্রাম/বাড়ি <span class="required">*</span></label>
                                    <input class="form-control form-input" type="text" name="village"
                                        placeholder="গ্রাম বা বাড়ির নাম" required>
                                </div>
                            </div>

                            <!-- Road/Block -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">রাস্তা/ব্লক/সেক্টর <span class="required">*</span></label>
                                    <input class="form-control form-input" type="text" name="road"
                                        placeholder="রাস্তা বা ব্লকের বিবরণ" required>
                                </div>
                            </div>

                            <!-- Police Station -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">থানা <span class="required">*</span></label>
                                    <input class="form-control form-input" type="text" name="police_station"
                                        placeholder="থানার নাম" required>
                                </div>
                            </div>

                            <!-- Post Office -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">পোস্ট অফিস <span class="required">*</span></label>
                                    <input class="form-control form-input" type="text" name="post_office"
                                        placeholder="পোস্ট অফিসের নাম" required>
                                </div>
                            </div>

                            <!-- District -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">জেলা <span class="required">*</span></label>
                                    <input class="form-control form-input" type="text" name="district"
                                        placeholder="জেলার নাম" required>
                                </div>
                            </div>

                            <!-- Post Code -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">পোস্টাল কোড <span class="required">*</span></label>
                                    <input class="form-control form-input" type="text" name="post_code"
                                        placeholder="পোস্টাল কোড (সংখ্যা)" required>
                                </div>
                            </div>

                            <!-- Country -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">দেশ <span class="required">*</span></label>
                                    <input class="form-control form-input" type="text" name="country"
                                        placeholder="দেশের নাম" required>
                                </div>
                            </div>

                            <!-- Address Description -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">ঠিকানা সম্পর্কে অতিরিক্ত তথ্য</label>
                                    <textarea class="form-control form-textarea" rows="3" name="personal_description"
                                        placeholder="আপনার ঠিকানা খুঁজে পেতে সাহায্য করবে এমন কোনো তথ্য লিখুন..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Settings Section -->
                <div class="form-section mt-5">
                    <div class="section-header">
                        <h2 class="section-title"><i class="fas fa-credit-card"></i> Payment Settings</h2>
                        <p class="section-subtitle">Select a payment method and provide the required information</p>
                    </div>

                    <div class="form-card">
                        <div class="row g-4">
                            <!-- Payment Gateway Selection -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label">Payment Method <span class="required">*</span></label>
                                    <select class="form-control form-select" name="payment_gateway" required
                                        onchange="updatePaymentFields()">
                                        <option value="sslcommerz">SSLCommerz (Recommended)</option>
                                        <option value="bkash">bKash Mobile Banking</option>
                                        <option value="bank">Bank Transfer</option>
                                    </select>
                                </div>
                            </div>

                            <!-- SSLCommerz Fields -->
                            <div class="col-lg-6 sslcommerz-fields">
                                <div class="form-group">
                                    <label class="form-label">SSLCommerz Store ID</label>
                                    <input class="form-control form-input english-only" type="text" name="store_id"
                                        placeholder="Your store ID">
                                </div>
                            </div>

                            <div class="col-lg-6 sslcommerz-fields">
                                <div class="form-group">
                                    <label class="form-label">SSLCommerz Store Password</label>
                                    <input class="form-control form-input english-only" type="password" name="store_password"
                                        placeholder="Your store password">
                                </div>
                            </div>

                            <!-- bKash Fields -->
                            <div class="col-lg-6 bkash-fields" style="display: none;">
                                <div class="form-group">
                                    <label class="form-label">bKash Number</label>
                                    <input class="form-control form-input english-only" type="text" name="bkash_number"
                                        placeholder="e.g. 01712345678">
                                </div>
                            </div>

                            <!-- Bank Fields -->
                            <div class="col-lg-6 bank-fields" style="display: none;">
                                <div class="form-group">
                                    <label class="form-label">Bank Name</label>
                                    <input class="form-control form-input english-only" type="text" name="bank_name"
                                        placeholder="e.g. Dhaka Bank">
                                </div>
                            </div>

                            <div class="col-lg-6 bank-fields" style="display: none;">
                                <div class="form-group">
                                    <label class="form-label">Account Number</label>
                                    <input class="form-control form-input english-only" type="text" name="bank_account"
                                        placeholder="Your account number">
                                </div>
                            </div>

                            <div class="col-lg-6 bank-fields" style="display: none;">
                                <div class="form-group">
                                    <label class="form-label">Routing Number</label>
                                    <input class="form-control form-input english-only" type="text" name="bank_routing"
                                        placeholder="Routing number">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-actions mt-5">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-check-circle"></i> পণ্য যোগ করুন
                    </button>
                </div>
            </form>
        </div>
    </section>

    <style>
        /* ============ Add Product Form Styles ============ */
        #add-product-page {
            background-color: #f8f9fa;
            min-height: calc(100vh - 200px);
        }

        /* Page Header */
        .page-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            font-size: 1.1rem;
            color: #666;
            margin: 0;
        }

        /* Form Sections */
        .form-section {
            margin-bottom: 2rem;
        }

        .section-header {
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.25rem;
        }

        .section-subtitle {
            color: #666;
            margin: 0;
            font-size: 0.95rem;
        }

        /* Form Card */
        .form-card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 0;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .required {
            color: #dc3545;
            margin-left: 3px;
        }

        .form-input,
        .form-select,
        .form-textarea {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background-color: #fff;
            color: #333;
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            border-color: #81B622;
            box-shadow: 0 0 0 3px rgba(129, 182, 34, 0.1);
            outline: none;
        }

        .form-textarea {
            resize: vertical;
            font-family: inherit;
        }

        .help-text {
            display: block;
            margin-top: 0.25rem;
            color: #999;
            font-size: 0.85rem;
        }

        /* Image Upload */
        .image-upload-group {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .image-preview-box {
            position: relative;
            width: 100%;
            aspect-ratio: 1;
            border: 2px dashed #ddd;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #f9f9f9;
            margin: 0.5rem 0;
            overflow: hidden;
        }

        .image-preview-box:hover {
            border-color: #81B622;
            background-color: #f0f7e8;
        }

        .image-preview-box i {
            font-size: 2.5rem;
            color: #ddd;
            margin-bottom: 0.5rem;
            transition: color 0.3s ease;
        }

        .image-preview-box p {
            margin: 0;
            color: #999;
            font-size: 0.85rem;
            text-align: center;
        }

        .image-preview-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-input {
            display: none;
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .btn-submit {
            background-color: #81B622;
            color: white;
            border: none;
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-submit:hover {
            background-color: #6fa01a;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(129, 182, 34, 0.3);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-title {
                font-size: 1.8rem;
            }

            .form-card {
                padding: 1.5rem;
            }

            .section-title {
                font-size: 1.2rem;
            }

            .btn-submit {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            #add-product-page {
                padding-top: 1rem;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .form-card {
                padding: 1rem;
            }

            .form-input,
            .form-select,
            .form-textarea {
                font-size: 1rem;
            }
        }
    </style>
@endsection

@section('scripts')
    <script>
        // Image Preview Function
        function loadFile(event, previewId) {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function() {
                const preview = document.getElementById(previewId);
                preview.innerHTML = `<img src="${reader.result}" alt="Preview">`;
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }

        // Update Payment Fields
        function updatePaymentFields() {
            const gateway = document.querySelector('select[name="payment_gateway"]').value;
            const sslFields = document.querySelectorAll('.sslcommerz-fields');
            const bkashFields = document.querySelectorAll('.bkash-fields');
            const bankFields = document.querySelectorAll('.bank-fields');

            // Hide all fields
            sslFields.forEach(el => el.style.display = 'none');
            bkashFields.forEach(el => el.style.display = 'none');
            bankFields.forEach(el => el.style.display = 'none');

            // Show selected gateway fields
            if (gateway === 'sslcommerz') {
                sslFields.forEach(el => el.style.display = 'block');
            } else if (gateway === 'bkash') {
                bkashFields.forEach(el => el.style.display = 'block');
            } else if (gateway === 'bank') {
                bankFields.forEach(el => el.style.display = 'block');
            }
        }

        function enforceEnglishInput(event) {
            const value = event.target.value;
            const filtered = value.replace(/[^\x00-\x7F]/g, '');
            if (value !== filtered) {
                event.target.value = filtered;
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updatePaymentFields();

            document.querySelectorAll('.english-only').forEach(input => {
                input.addEventListener('input', enforceEnglishInput);
            });

            // Handle click on preview box to trigger file input
            document.querySelectorAll('.image-preview-box').forEach(box => {
                box.addEventListener('click', function() {
                    this.nextElementSibling.click();
                });
            });
        });
    </script>
@endsection
