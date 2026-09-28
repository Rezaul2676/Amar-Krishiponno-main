@extends('layouts.frontend_layout')

@section('title')
    AgroBd - Business Seller Payment
@endsection

@section('frontend_content')
    <div class="container mt-5 pt-5">
        <div class="row">
            <div class="col-md-8 mb-4">
                <div class="card p-4" style="background: #f8f9fa;">
                    <h3 class="mb-4">{{ $business->product_name }} পণ্যটি কিনতে পরিশোধ করুন</h3>

                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('suspicious_reasons'))
                        <div class="alert alert-danger">
                            <p><strong>পেমেন্ট আটকে গেছে:</strong> আপনার কিছু ইনপুট সন্দেহজনক মনে হয়েছে, তাই ফর্মটি এখন এগোতে পারছে না।</p>
                            <p class="mb-1"><strong>কেন আটকে গেছে:</strong></p>
                            <ul class="mb-0">
                                @foreach (session('suspicious_reasons') as $reason)
                                    <li>{{ $reason }}</li>
                                @endforeach
                            </ul>
                            <p class="mb-0 mt-2"><strong>কি করলে পরবর্তী ধাপে যাবে:</strong> উপরের কারণগুলো ঠিক করুন, বিশেষ করে নাম, ঠিকানা বা স্টেটে সাধারণ ও স্পষ্ট বাংলা/ইংরেজি লিখে আবার সাবমিট করুন।</p>
                        </div>
                    @endif

                    <style>
                        .autocomplete-suggestions {
                            position: absolute;
                            left: 0;
                            right: 0;
                            top: calc(100% + 0.25rem);
                            z-index: 10;
                            max-height: 200px;
                            overflow-y: auto;
                            border: 1px solid #ced4da;
                            border-radius: 0.25rem;
                            background: #fff;
                            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
                        }

                        .autocomplete-suggestion {
                            padding: 0.5rem 0.75rem;
                            cursor: pointer;
                        }

                        .autocomplete-suggestion:hover {
                            background-color: #f1f1f1;
                        }
                    </style>

                    <form action="{{ url('pay-business') }}" method="POST">
                        @csrf
                        <input type="hidden" name="business_id" value="{{ $business->id }}">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>পণ্য</label>
                                <input type="text" class="form-control" value="{{ $business->product_name }}" readonly>
                            </div>
                                 <div class="col-md-6 mb-3">
                                <label>মোট পরিমাণ (টাকা)</label>
                                <input type="text" id="total_amount" class="form-control" name="amount"
                                    value="{{ $business->price * old('quantity', $quantity ?? 1) }}" readonly required>
                            </div>
                        </div>

                        <input type="hidden" name="quantity" value="{{ old('quantity', $quantity ?? 1) }}">

                        <!-- <div class="row">
                            <div class="col-md-6 mb-3"> 
                                <label>Price per kg (TK)</label>
                                <input type="text" class="form-control" value="{{ $business->price }}" readonly>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Quantity (kg)</label>
                                <input type="number" name="quantity" id="quantity" class="form-control"
                                    value="{{ old('quantity', $quantity ?? 1) }}" min="1"
                                    max="{{ $business->product_quantity }}" required>
                                @error('quantity')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> -->

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>আপনার নাম</label>
                                <input id="name" type="text" name="name" lang="bn" dir="auto"
                                    class="form-control {{ $errors->has('name') ? 'is-invalid' : (old('name') ? 'is-valid' : '') }}"
                                    data-server-error="{{ $errors->has('name') ? '1' : '0' }}" readonly
                                    value="{{ old('name', Auth::user()->name ?? '') }}" required placeholder="আপনার পূর্ণ নাম লিখুন">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>আপনার ইমেইল</label>
                                <input id="email" type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : (old('email') ? 'is-valid' : '') }}"
                                    data-server-error="{{ $errors->has('email') ? '1' : '0' }}" readonly
                                    value="{{ old('email', Auth::user()->email ?? '') }}" required placeholder="name@example.com">
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>ফোন নম্বর</label>
                                <input id="phone" type="tel" name="phone" lang="bn" dir="auto" inputmode="numeric"
                                    class="form-control {{ $errors->has('phone') ? 'is-invalid' : (old('phone') ? 'is-valid' : '') }}"
                                    value="{{ old('phone', Auth::user()->phone ?? '') }}"
                                    data-server-error="{{ $errors->has('phone') ? '1' : '0' }}"
                                    pattern="[0-9]{11}" minlength="11" maxlength="11" required placeholder="01316057864">
                                @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>পোস্ট কোড</label>
                                <input id="post_code" type="text" name="post_code" lang="bn" dir="auto" inputmode="numeric"
                                    class="form-control {{ $errors->has('post_code') ? 'is-invalid' : (old('post_code') ? 'is-valid' : '') }}" value="{{ old('post_code') }}"
                                    data-server-error="{{ $errors->has('post_code') ? '1' : '0' }}"
                                    pattern="[0-9]{4,6}" required placeholder="1234">
                                @error('post_code')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3 position-relative">
                            <label>সম্পূর্ণ ঠিকানা</label>
                            <input id="address" type="text" name="address" lang="bn" dir="auto"
                                class="form-control {{ $errors->has('address') ? 'is-invalid' : (old('address') ? 'is-valid' : '') }}" value="{{ old('address') }}"
                                data-server-error="{{ $errors->has('address') ? '1' : '0' }}"
                                minlength="10" required placeholder="বাড়ি/ব্লক, রাস্তা, এলাকা, জেলা">
                            <div id="address-suggestions" class="autocomplete-suggestions d-none"></div>
                            <div class="invalid-feedback">দয়া করে বাংলাদেশের বৈধ ঠিকানা লিখুন। ঠিকানা/জেলা/উপজেলার নাম অন্তর্ভুক্ত করুন।</div>
                            @error('address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 position-relative">
                            <label>জেলা / উপজেলা / থানা</label>
                            <input id="state" type="text" name="state" lang="bn" dir="auto"
                                class="form-control {{ $errors->has('state') ? 'is-invalid' : (old('state') ? 'is-valid' : '') }}" value="{{ old('state') }}" minlength="3" required
                                data-server-error="{{ $errors->has('state') ? '1' : '0' }}" placeholder="যেমন: ঢাকা, গাজীপুর, সাভার, নারায়ণগঞ্জ">
                            <div id="state-suggestions" class="autocomplete-suggestions d-none"></div>
                            <div class="invalid-feedback">দয়া করে বাংলাদেশের বৈধ জেলা/উপজেলা/থানার নাম লিখুন।</div>
                            @error('state')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>পেমেন্ট পদ্ধতি</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="payment_method_bkash" value="bkash" {{ old('payment_method', 'bkash') == 'bkash' ? 'checked' : '' }}>
                                <label class="form-check-label" for="payment_method_bkash">bKash Payment</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment_method" id="payment_method_handcash" value="handcash" {{ old('payment_method') == 'handcash' ? 'checked' : '' }}>
                                <label class="form-check-label" for="payment_method_handcash">Hand Cash</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>বিক্রেতার জন্য নোট (ঐচ্ছিক)</label>
                            <textarea name="description" class="form-control" rows="3" lang="bn" dir="auto">আমি {{ $business->name }} থেকে {{ $business->product_name }} এর জন্য পারিশ্রমিক দিচ্ছি।</textarea>
                        </div>

                        <button type="submit" class="btn btn-success btn-lg" id="payment_submit_button">Pay with bKash</button>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-4" style="background: #f8f9fa;">
                    <h4 class="mb-3">বিক্রেতার বিবরণ</h4>
                    <p><strong>বিক্রেতা:</strong> {{ $business->name }}</p>
                    <p><strong>ফোন:</strong> {{ $business->phone }}</p>
                    <p><strong>ইমেইল:</strong> {{ $business->email }}</p>
                    <p><strong>অবস্থান:</strong> {{ $business->district }}, {{ $business->country }}</p>
                    <p><strong>স্টক:</strong> {{ $business->product_quantity }} kg</p>
                    <p><strong>বিবরণ:</strong>
                        {{ \Illuminate\Support\Str::limit($business->personal_description, 120) }}</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantity = document.getElementById('quantity');
            const totalInput = document.getElementById('total_amount');
            const price = {{ $business->price }};

            if (quantity && totalInput) {
                function updateTotal() {
                    let qty = parseInt(quantity.value) || 1;
                    if (qty < 1) qty = 1;
                    if (qty > {{ $business->product_quantity }}) {
                        qty = {{ $business->product_quantity }};
                        quantity.value = qty;
                    }
                    totalInput.value = qty * price;
                }

                quantity.addEventListener('input', updateTotal);
                updateTotal();
            }

            const paymentSubmitButton = document.getElementById('payment_submit_button');
            const paymentMethodRadios = document.querySelectorAll('input[name="payment_method"]');

            function updatePaymentButtonLabel() {
                if (!paymentSubmitButton) return;
                const selected = document.querySelector('input[name="payment_method"]:checked');
                if (selected && selected.value === 'handcash') {
                    paymentSubmitButton.textContent = 'Pay with Hand Cash';
                } else {
                    paymentSubmitButton.textContent = 'Pay with bKash';
                }
            }

            if (paymentMethodRadios.length) {
                paymentMethodRadios.forEach(radio => radio.addEventListener('change', updatePaymentButtonLabel));
                updatePaymentButtonLabel();
            }

            function convertBanglaDigitsToEnglish(value) {
                const banglaDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
                const englishDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

                return String(value || '').replace(/[০১২৩৪৫৬৭৮৯]/g, (char) => {
                    const index = banglaDigits.indexOf(char);
                    return index >= 0 ? englishDigits[index] : char;
                });
            }

            const bangladeshDistricts = @json(\App\Services\BangladeshLocationValidator::getDistricts());
            const bangladeshUpazilas = @json(\App\Services\BangladeshLocationValidator::getUpazilas());
            const bangladeshThanas = @json(\App\Services\BangladeshLocationValidator::getThanaNames());
            const banglaLocationNames = Object.values(@json(\App\Services\BangladeshLocationValidator::getBanglaAliases()));

            function normalizeLocationText(value) {
                return String(value || '')
                    .toLowerCase()
                    .replace(/[^\p{L}\p{N}\s]/gu, ' ')
                    .replace(/\s+/gu, ' ')
                    .trim();
            }

            function looksLikeBangladeshLocation(value, minLength = 10) {
                const text = normalizeLocationText(value);
                if (!text || text.length < minLength) {
                    return false;
                }
                return /[\p{L}\p{N}]/u.test(text);
            }

            function escapeRegExp(value) {
                return String(value || '').replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
            }

            function containsBangladeshLocationMatch(value) {
                const text = normalizeLocationText(value);
                if (!text) return false;

                const names = [...bangladeshDistricts, ...bangladeshUpazilas, ...bangladeshThanas, ...banglaLocationNames];
                const paddedText = ` ${text} `;

                for (const name of names) {
                    const normalizedName = normalizeLocationText(name);
                    if (!normalizedName || normalizedName.length < 3) continue;

                    const pattern = new RegExp(`(^|\\s)${escapeRegExp(normalizedName)}($|\\s)`, 'u');
                    if (pattern.test(paddedText)) {
                        return true;
                    }
                }

                return false;
            }

            const combinedLocationNames = [...new Set([...bangladeshDistricts, ...bangladeshUpazilas, ...bangladeshThanas, ...banglaLocationNames])];

            function getSuggestionItems(query, items) {
                const normalizedQuery = normalizeLocationText(query);
                if (!normalizedQuery || normalizedQuery.length < 2) {
                    return [];
                }
                return items
                    .map(name => ({ name, normalized: normalizeLocationText(name) }))
                    .filter(item => item.normalized.includes(normalizedQuery))
                    .slice(0, 8);
            }

            function clearSuggestions(container) {
                container.innerHTML = '';
                container.classList.add('d-none');
            }

            function renderSuggestions(container, suggestions, inputField) {
                container.innerHTML = '';
                if (!suggestions.length) {
                    container.classList.add('d-none');
                    return;
                }
                suggestions.forEach(item => {
                    const div = document.createElement('div');
                    div.className = 'autocomplete-suggestion';
                    div.textContent = item.name;
                    div.addEventListener('mousedown', function(event) {
                        event.preventDefault();
                        inputField.value = item.name;
                        inputField.dispatchEvent(new Event('input'));
                        clearSuggestions(container);
                    });
                    container.appendChild(div);
                });
                container.classList.remove('d-none');
            }

            function setupAutocomplete(inputField, suggestionContainer, items) {
                inputField.setAttribute('autocomplete', 'off');

                inputField.addEventListener('input', function() {
                    const query = inputField.value;
                    const suggestions = getSuggestionItems(query, items);
                    renderSuggestions(suggestionContainer, suggestions, inputField);
                });

                inputField.addEventListener('blur', function() {
                    setTimeout(() => clearSuggestions(suggestionContainer), 200);
                });
            }

            function stateIsValid(value) {
                const normalized = (value || '').trim();
                if (!normalized) {
                    return false;
                }
                return containsBangladeshLocationMatch(normalized);
            }

            const validators = {
                name: value => true,
                email: value => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value.trim()),
                phone: value => /^[0-9]{11}$/.test(value.trim()),
                post_code: value => /^[0-9]{4,6}$/.test(value.trim()),
                address: value => {
                    const trimmed = (value || '').trim();
                    if (trimmed.length < 10 || trimmed.length > 500) return false;
                    return containsBangladeshLocationMatch(trimmed);
                },
                state: value => stateIsValid(value),
            };

            function validateField(field) {
                if (field.name === 'phone' || field.name === 'post_code') {
                    const converted = convertBanglaDigitsToEnglish(field.value);
                    if (converted !== field.value) {
                        field.value = converted;
                    }
                }

                const value = field.value;
                const isValid = validators[field.name] ? validators[field.name](value) : true;
                field.classList.toggle('is-valid', isValid);
                field.classList.toggle('is-invalid', !isValid);
                field.setCustomValidity(isValid ? '' : 'invalid');
                if (!isValid) {
                    field.setAttribute('aria-invalid', 'true');
                } else {
                    field.removeAttribute('aria-invalid');
                }
                return isValid;
            }

            const fields = ['name', 'email', 'phone', 'post_code', 'address', 'state']
                .map(id => document.getElementById(id))
                .filter(Boolean);

            const addressInput = document.getElementById('address');
            const addressSuggestions = document.getElementById('address-suggestions');
            const stateInput = document.getElementById('state');
            const stateSuggestions = document.getElementById('state-suggestions');

            if (addressInput && addressSuggestions) {
                const addressItems = [...bangladeshDistricts, ...bangladeshUpazilas, ...bangladeshThanas];
                setupAutocomplete(addressInput, addressSuggestions, addressItems);
            }

            if (stateInput && stateSuggestions) {
                setupAutocomplete(stateInput, stateSuggestions, bangladeshDistricts.concat(bangladeshUpazilas));
            }

            fields.forEach(field => {
                let hasServerError = field.dataset.serverError === '1';

                if (hasServerError) {
                    field.classList.add('is-invalid');
                    field.classList.remove('is-valid');
                } else {
                    validateField(field);
                }

                // When the user edits a field that previously had a server error,
                // clear the server-error flag and re-run validation so the UI updates.
                field.addEventListener('input', () => {
                    if (hasServerError) {
                        field.dataset.serverError = '0';
                        hasServerError = false;
                        field.classList.remove('is-invalid');
                    }
                    validateField(field);
                });

                field.addEventListener('blur', () => {
                    if (hasServerError) {
                        field.dataset.serverError = '0';
                        hasServerError = false;
                        field.classList.remove('is-invalid');
                    }
                    validateField(field);
                });
            });

            const form = document.querySelector('form[action="{{ url('pay-business') }}"]');
            if (form) {
                form.addEventListener('submit', function(event) {
                    let valid = true;
                    let firstInvalidField = null;

                    fields.forEach(field => {
                        const isValid = validateField(field);
                        if (!isValid && !firstInvalidField) {
                            firstInvalidField = field;
                        }
                        if (!isValid) {
                            valid = false;
                        }
                    });

                    if (!valid) {
                        event.preventDefault();
                        event.stopPropagation();

                        if (firstInvalidField) {
                            firstInvalidField.focus();
                            firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    }
                });
            }
        });
    </script>
@endsection
