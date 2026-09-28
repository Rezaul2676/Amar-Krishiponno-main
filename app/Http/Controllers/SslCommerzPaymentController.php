<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\Business\MyBusiness;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderitemPayment;
use App\Models\OrderPayment;
use App\Models\Payment;
use App\Models\Product;
use App\Models\SellerBuyer;
use App\Services\BangladeshLocationValidator;
use App\Services\FraudDetectionService;
use App\Services\SuspiciousInputDetector;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

class SslCommerzPaymentController extends Controller
{

    public function exampleEasyCheckout()
    {
        return view('frontend.payment.exampleEasycheckout');
    }

    public function exampleHostedCheckout()
    {
        return view('frontend.payment.exampleHosted');
    }

    public function businessPaymentForm(Request $request, $id)
    {
        $business = MyBusiness::findOrFail($id);
        $quantity = (int) $request->query('quantity', 1);
        if ($quantity < 1) {
            $quantity = 1;
        }
        if ($quantity > $business->product_quantity) {
            $quantity = $business->product_quantity;
        }
        return view('frontend.payment.business_payment', compact('business', 'quantity'));
    }

    public function payBusiness(Request $request)
    {
        $request->validate([
            'business_id' => 'required|integer|exists:my_businesses,id',
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:bkash,handcash',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => ['required', 'string', 'regex:/^[0-9]{11}$/'],
            'address' => [
                'required',
                'string',
                'min:10',
                'max:500',
                function ($attribute, $value, $fail) {
                    if (!BangladeshLocationValidator::isValidAddress($value)) {
                        $fail('ঠিকানাটি সন্দেহজনক বা অবৈধ মনে হচ্ছে। দয়া করে পূর্ণ ও সঠিক ঠিকানা লিখুন।');
                    }
                },
            ],
            'state' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'regex:/^[\pL\pM\.\-\s,]+$/u',
                function ($attribute, $value, $fail) {
                    if (!BangladeshLocationValidator::isValidState($value)) {
                        $fail('স্টেট/জেলা/উপজেলার নামটি বৈধ নয়। বাংলাদেশি জেলা বা উপজেলার নাম লিখুন।');
                    }
                },
            ],
            'post_code' => 'required|digits_between:4,6',
        ],[
            'name.required' => 'নামের ফাঁকা রাখা যাবে না।',
            'name.min' => 'নাম কমপক্ষে ৩ অক্ষরের হতে হবে।',
            'name.max' => 'নাম ২৫৫ অক্ষরের বেশি হতে পারবে না।',
            'name.regex' => 'নামে শুধুমাত্র অক্ষর, স্পেস, ডট বা হাইফেন থাকতে পারে।',
            'email.required' => 'ইমেইল আবশ্যক।',
            'email.email' => 'ইমেইল ঠিকানাটি সঠিক নয়।',
            'phone.required' => 'ফোন নম্বর আবশ্যক।',
            'phone.regex' => 'ফোন নম্বর ১১ ডিজিটের হতে হবে।',
            'address.required' => 'ঠিকানাটি আবশ্যক।',
            'address.min' => 'ঠিকানাটি কমপক্ষে ১০ অক্ষরের হতে হবে।',
            'address.max' => 'ঠিকানাটি ৫০০ অক্ষরের বেশি হতে পারবে না।',
            'state.required' => 'স্টেটের নাম আবশ্যক।',
            'state.min' => 'স্টেটের নাম কমপক্ষে ৩ অক্ষরের হতে হবে।',
            'state.max' => 'স্টেটের নাম ২৫৫ অক্ষরের বেশি হতে পারবে না।',
            'state.regex' => 'স্টেটে শুধুমাত্র অক্ষর, স্পেস, ডট বা হাইফেন থাকতে পারে।',
            'post_code.required' => 'পোস্ট কোড আবশ্যক।',
            'post_code.digits_between' => 'পোস্ট কোড ৪ থেকে ৬ ডিজিটের হতে হবে।',
        ]);

        $business = MyBusiness::findOrFail($request->business_id);
        $quantity = $request->input('quantity', 1);
        $amount = $business->price * $quantity;

        $detector = new SuspiciousInputDetector();
        $result = $detector->detect($request->only(['name', 'address', 'state', 'post_code']));

        $paymentMethod = $request->input('payment_method', $business->payment_gateway ?? 'bkash');

        if ($result['is_suspicious']) {
            $fieldErrors = [];
            $filteredReasons = array_filter($result['reasons'], function ($reason) {
                return stripos($reason, 'নামে') === false && stripos($reason, 'name') === false;
            });

            foreach ($filteredReasons as $reason) {
                if (stripos($reason, 'ঠিকানায়') !== false || stripos($reason, 'address') !== false) {
                    $fieldErrors['address'] = $fieldErrors['address'] ?? 'ঠিকানাটি সন্দেহজনক মনে হচ্ছে। একটি সঠিক ঠিকানা দিন।';
                }
                if (stripos($reason, 'স্টেটে') !== false || stripos($reason, 'state') !== false) {
                    $fieldErrors['state'] = $fieldErrors['state'] ?? 'স্টেট সন্দেহজনক হচ্ছে। একটি সঠিক স্টেট বা জেলার নাম দিন।';
                }
            }

            if (empty($fieldErrors)) {
                // Ignore name-only reasons; do not block checkout for name validation.
                if ($paymentMethod === 'handcash') {
                    return $this->payBusinessHandCash($request, $business, $amount, $quantity);
                }
                return $this->payBusinessBkash($request, $business, $amount, $quantity);
            }

            return redirect()->back()
                ->withInput()
                ->withErrors($fieldErrors)
                ->with('suspicious_reasons', $result['reasons']);
        }

        if ($quantity < 1) {
            $quantity = 1;
        }

        if ($quantity > $business->product_quantity) {
            return redirect()->back()->with('error', 'Requested quantity exceeds available stock.');
        }

        $amount = $business->price * $quantity;

        if ($paymentMethod === 'handcash') {
            return $this->payBusinessHandCash($request, $business, $amount, $quantity);
        }

        // Route to correct payment gateway
        if ($paymentMethod === 'bkash') {
            if (!$business->bkash_number) {
                return redirect()->back()->with('error', 'Seller has not configured bKash number. Please ask seller to update their business profile.');
            }
            return $this->payBusinessBkash($request, $business, $amount, $quantity);
        }

        return redirect()->back()->with('error', 'Invalid payment method selected.');
    }

    public function payBusinessSSLCommerz(Request $request, MyBusiness $business, $amount, $quantity)
    {
        if (!$business->store_id || !$business->store_password) {
            return view('frontend.payment.payment_not_configured');
        }

        $post_data = [];
        $post_data['total_amount'] = $amount;
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid();

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $request->name ?? Auth::user()->name;
        $post_data['cus_email'] = $request->email ?? Auth::user()->email;
        $post_data['cus_add1'] = $request->address;
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = $request->state;
        $post_data['cus_postcode'] = $request->post_code;
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = $request->phone;
        $post_data['cus_fax'] = "";
        $post_data['description'] = $request->description ?? "Payment to seller {$business->name} for {$business->product_name} ({$quantity} kg)";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = $business->name;
        $post_data['ship_add1'] = $business->village;
        $post_data['ship_add2'] = $business->road;
        $post_data['ship_city'] = $business->district;
        $post_data['ship_state'] = $business->police_station;
        $post_data['ship_postcode'] = $business->post_code;
        $post_data['ship_phone'] = $business->phone;
        $post_data['ship_country'] = $business->country;

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = $business->product_name;
        $post_data['product_category'] = $business->category;
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "seller_id:{$business->user_id}";
        $post_data['value_b'] = "business_id:{$business->id}";
        $post_data['value_c'] = "quantity:{$quantity}";
        $post_data['value_d'] = "payment_type:business_seller";

        $order_id = OrderPayment::insertGetId([
            'user_id' => Auth::id(),
            'invoice_no' => mt_rand(10000000, 99999999),
            'payment_type' => 'SSLCommerz',
            'total' => $amount,
            'subtotal' => $amount,
            'discount_percentage' => null,
            'status' => 0,
            'created_at' => Carbon::now(),
        ]);

        OrderitemPayment::insert([
            'order_id' => $order_id,
            'product_id' => $business->id,
            'product_qty' => $quantity,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $payment_record = DB::table('payments')->updateOrInsert(
            ['transaction_id' => $post_data['tran_id']],
            [
                'order_id' => $order_id,
                'user_id' => Auth::id(),
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'state' => $post_data['cus_state'],
                'post_code' => $post_data['cus_postcode'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency'],
                'description' => $post_data['description'],
                'business_id' => $business->id,
                'seller_id' => $business->user_id,
                'quantity' => $quantity,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        );

        $sslc = new SslCommerzNotification($business->store_id, $business->store_password);
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = [];
        }
    }

    public function payBusinessBkash(Request $request, MyBusiness $business, $amount, $quantity)
    {
        $tran_id = uniqid();

        $payment_record = DB::table('payments')->insert([
            'order_id' => null,
            'user_id' => Auth::id(),
            'name' => $request->name ?? Auth::user()->name,
            'email' => $request->email ?? Auth::user()->email,
            'phone' => $request->phone,
            'amount' => $amount,
            'status' => 'Pending',
            'address' => $request->address,
            'state' => $request->state,
            'post_code' => $request->post_code,
            'transaction_id' => $tran_id,
            'currency' => 'BDT',
            'description' => $request->description ?? "bKash payment to seller {$business->name} for {$business->product_name} ({$quantity} kg)",
            'business_id' => $business->id,
            'seller_id' => $business->user_id,
            'quantity' => $quantity,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        if (Session::has('discount')) {
            session()->forget('discount');
        }

        return view('frontend.payment.bkash_instruction', [
            'business' => $business,
            'amount' => $amount,
            'tran_id' => $tran_id,
            'quantity' => $quantity
        ]);
    }

    public function payBusinessBank(Request $request, MyBusiness $business, $amount, $quantity)
    {
        $tran_id = uniqid();

        $payment_record = DB::table('payments')->insert([
            'order_id' => null,
            'user_id' => Auth::id(),
            'name' => $request->name ?? Auth::user()->name,
            'email' => $request->email ?? Auth::user()->email,
            'phone' => $request->phone,
            'amount' => $amount,
            'status' => 'Pending',
            'address' => $request->address,
            'state' => $request->state,
            'post_code' => $request->post_code,
            'transaction_id' => $tran_id,
            'currency' => 'BDT',
            'description' => $request->description ?? "Bank transfer to seller {$business->name} for {$business->product_name} ({$quantity} kg)",
            'business_id' => $business->id,
            'seller_id' => $business->user_id,
            'quantity' => $quantity,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        if (Session::has('discount')) {
            session()->forget('discount');
        }

        return view('frontend.payment.bank_instruction', [
            'business' => $business,
            'amount' => $amount,
            'tran_id' => $tran_id,
            'quantity' => $quantity
        ]);
    }

    public function payBusinessHandCash(Request $request, MyBusiness $business, $amount, $quantity)
    {
        $tran_id = 'handcash_' . uniqid();

        $order_id = OrderPayment::insertGetId([
            'user_id' => Auth::id(),
            'invoice_no' => mt_rand(10000000, 99999999),
            'payment_type' => 'Hand Cash',
            'total' => $amount,
            'subtotal' => $amount,
            'discount_percentage' => null,
            'status' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        OrderitemPayment::insert([
            'order_id' => $order_id,
            'product_id' => $business->id,
            'product_qty' => $quantity,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $payment_id = DB::table('payments')->insertGetId([
            'order_id' => $order_id,
            'user_id' => Auth::id(),
            'name' => $request->name ?? Auth::user()->name,
            'email' => $request->email ?? Auth::user()->email,
            'phone' => $request->phone,
            'amount' => $amount,
            'status' => 'Pending',
            'address' => $request->address,
            'state' => $request->state,
            'post_code' => $request->post_code,
            'transaction_id' => $tran_id,
            'currency' => 'BDT',
            'description' => $request->description ?? "Hand Cash order for {$business->product_name} ({$quantity} kg) to seller {$business->name}",
            'business_id' => $business->id,
            'seller_id' => $business->user_id,
            'quantity' => $quantity,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $this->createSellerBuyerRecord([
            'seller_id' => $business->user_id,
            'business_id' => $business->id,
            'product_name' => $business->product_name,
            'buyer_id' => Auth::id(),
            'buyer_name' => $request->name ?? Auth::user()->name,
            'buyer_email' => $request->email ?? Auth::user()->email,
            'buyer_phone' => $request->phone,
            'buyer_address' => $request->address,
            'buyer_state' => $request->state,
            'buyer_post_code' => $request->post_code,
            'quantity' => $quantity,
            'amount' => $amount,
            'transaction_id' => $tran_id,
            'payment_status' => 'pending',
            'notes' => 'Hand Cash order placed, awaiting collection.',
        ], $paymentMethod, [
            'source' => 'handcash',
        ]);

        if (Session::has('discount')) {
            session()->forget('discount');
        }

        $payment = DB::table('payments')->where('id', $payment_id)->first();

        return view('frontend.payment.payment_success', [
            'payment' => $payment,
            'business' => $business,
            'transaction_ref' => 'Hand Cash',
            'payment_method' => 'Hand Cash',
            'quantity' => $quantity,
        ]);
    }

    protected function createSellerBuyerRecord(array $fields, string $paymentGateway, array $metadata = []): SellerBuyer
    {
        $basePayload = array_merge($fields, [
            'buyer_ip' => request()->ip(),
            'payment_gateway' => $paymentGateway,
        ]);

        $fraudResult = (new FraudDetectionService())->score($basePayload);

        $insertFields = array_merge($fields, [
            'buyer_ip' => request()->ip(),
            'payment_gateway' => $paymentGateway,
            'payment_metadata' => $metadata ?: null,
            'fraud_score' => $fraudResult['score'],
            'fraud_status' => $fraudResult['risk_level'],
        ]);

        return SellerBuyer::create(array_filter($insertFields, function ($value, $column) {
            return Schema::hasColumn('seller_buyers', $column);
        }, ARRAY_FILTER_USE_BOTH));
    }

    public function confirmBkashPayment(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|string',
            'bkash_transaction_ref' => 'required|string',
            'business_id' => 'required|integer',
            'amount' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);

        $payment = DB::table('payments')->where('transaction_id', $request->transaction_id)->first();
        if (!$payment) {
            return redirect()->back()->with('error', 'Payment record not found.');
        }

        $order_id = null;

        if (empty($payment->order_id)) {
            $order_id = OrderPayment::insertGetId([
                'user_id' => Auth::id(),
                'invoice_no' => mt_rand(10000000, 99999999),
                'payment_type' => 'bKash',
                'total' => $request->amount,
                'subtotal' => $request->amount,
                'discount_percentage' => null,
                'status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            OrderitemPayment::insert([
                'order_id' => $order_id,
                'product_id' => $request->business_id,
                'product_qty' => $request->quantity,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            DB::table('payments')->where('transaction_id', $request->transaction_id)->update([
                'order_id' => $order_id,
                'updated_at' => Carbon::now(),
            ]);
        } else {
            $order_id = $payment->order_id;
        }

        DB::table('payments')->where('transaction_id', $request->transaction_id)->update([
            'status' => 'Completed',
            'description' => $payment->description . " | bKash Ref: {$request->bkash_transaction_ref}",
            'updated_at' => Carbon::now(),
        ]);

        // Save buyer information to seller_buyers table
        if ($payment->seller_id && $payment->business_id) {
            $business = MyBusiness::find($payment->business_id);
            $this->createSellerBuyerRecord([
                'seller_id' => $payment->seller_id,
                'business_id' => $payment->business_id,
                'product_name' => $business?->product_name,
                'buyer_id' => $payment->user_id,
                'buyer_name' => $payment->name,
                'buyer_email' => $payment->email,
                'buyer_phone' => $payment->phone,
                'buyer_address' => $payment->address,
                'buyer_state' => $payment->state,
                'buyer_post_code' => $payment->post_code,
                'quantity' => $payment->quantity ?? 1,
                'amount' => $request->amount,
                'transaction_id' => $request->transaction_id,
                'payment_status' => 'pending',
                'notes' => "bKash payment confirmed - Ref: {$request->bkash_transaction_ref}",
            ], 'bkash', [
                'bkash_transaction_ref' => $request->bkash_transaction_ref,
            ]);
        }

        $business = MyBusiness::findOrFail($request->business_id);

        return view('frontend.payment.payment_success', [
            'payment' => $payment,
            'business' => $business,
            'transaction_ref' => $request->bkash_transaction_ref,
            'payment_method' => 'bKash',
            'quantity' => $request->quantity,
        ]);
    }

    public function confirmBankPayment(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|string',
            'bank_transaction_ref' => 'required|string',
            'business_id' => 'required|integer',
            'amount' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);

        $payment = DB::table('payments')->where('transaction_id', $request->transaction_id)->first();
        if (!$payment) {
            return redirect()->back()->with('error', 'Payment record not found.');
        }

        $order_id = null;

        if (empty($payment->order_id)) {
            $order_id = OrderPayment::insertGetId([
                'user_id' => Auth::id(),
                'invoice_no' => mt_rand(10000000, 99999999),
                'payment_type' => 'Bank Transfer',
                'total' => $request->amount,
                'subtotal' => $request->amount,
                'discount_percentage' => null,
                'status' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            OrderitemPayment::insert([
                'order_id' => $order_id,
                'product_id' => $request->business_id,
                'product_qty' => $request->quantity,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            DB::table('payments')->where('transaction_id', $request->transaction_id)->update([
                'order_id' => $order_id,
                'updated_at' => Carbon::now(),
            ]);
        } else {
            $order_id = $payment->order_id;
        }

        DB::table('payments')->where('transaction_id', $request->transaction_id)->update([
            'status' => 'Completed',
            'description' => $payment->description . " | Bank Ref: {$request->bank_transaction_ref}",
            'updated_at' => Carbon::now(),
        ]);

        // Save buyer information to seller_buyers table
        if ($payment->seller_id && $payment->business_id) {
            $business = MyBusiness::find($payment->business_id);
            $this->createSellerBuyerRecord([
                'seller_id' => $payment->seller_id,
                'business_id' => $payment->business_id,
                'product_name' => $business?->product_name,
                'buyer_id' => $payment->user_id,
                'buyer_name' => $payment->name,
                'buyer_email' => $payment->email,
                'buyer_phone' => $payment->phone,
                'buyer_address' => $payment->address,
                'buyer_state' => $payment->state,
                'buyer_post_code' => $payment->post_code,
                'quantity' => $payment->quantity ?? 1,
                'amount' => $request->amount,
                'transaction_id' => $request->transaction_id,
                'payment_status' => 'pending',
                'notes' => "Bank transfer confirmed - Ref: {$request->bank_transaction_ref}",
            ], 'bank', [
                'bank_transaction_ref' => $request->bank_transaction_ref,
            ]);
        }

        $business = MyBusiness::findOrFail($request->business_id);

        return view('frontend.payment.payment_success', [
            'payment' => $payment,
            'business' => $business,
            'transaction_ref' => $request->bank_transaction_ref,
            'payment_method' => 'Bank Transfer',
            'quantity' => $request->quantity,
        ]);
    }

    public function index(Request $request)
    {
        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "payments"
        # In "payments" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();

        $post_data['total_amount'] = $request->amount; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $request->name;
        $post_data['cus_email'] = $request->email;
        $post_data['cus_add1'] = $request->address;
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = $request->state;
        $post_data['cus_postcode'] = $request->post_code;
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = $request->phone;
        $post_data['cus_fax'] = "";
        $post_data['description'] = $request->description;


        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";


        //**************************** */
        $quantity = (int) $request->input('quantity', 1);
        $quantity = $quantity > 0 ? $quantity : 1;
        $productId = $request->input('product_id');
        $businessId = $request->input('business_id');
        $business = null;

        if ($businessId) {
            $business = MyBusiness::find($businessId);
        }

        $order_id = OrderPayment::insertGetId([
            'user_id' => Auth::id(),
            'invoice_no' => mt_rand(10000000, 99999999),
            'payment_type' => 'SSLCommerz',
            'total' => $request->input('total', $request->amount),
            'subtotal' => $request->input('subtotal', $request->amount),
            'discount_percentage' => $request->input('discount_percentage'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $cartItems = Cart::where('user_id', Auth::id())->where('user_ip', request()->ip())->get();
        if ($cartItems->isNotEmpty()) {
            foreach ($cartItems as $cartItem) {
                OrderitemPayment::insert([
                    'order_id' => $order_id,
                    'product_id' => $cartItem->product_id,
                    'product_qty' => $cartItem->qty,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        } else {
            $orderProductId = $productId ?: ($business?->id);
            if ($orderProductId) {
                OrderitemPayment::insert([
                    'order_id' => $order_id,
                    'product_id' => $orderProductId,
                    'product_qty' => $quantity,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

        $request->validate([
            'post_code' => 'integer',
        ]);
        #Before  going to initiate the payment order status need to insert or update as Pending.
        $sellerId = $business?->user_id;

        $update_product = DB::table('payments')->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'order_id' => $order_id,
                'user_id' => auth()->id(),
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'state' => $post_data['cus_state'],
                'post_code' => $post_data['cus_postcode'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency'],
                'description' => $post_data['description'],
                'business_id' => $business?->id,
                'seller_id' => $sellerId,
                'quantity' => $quantity,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

        if (Session::has('discount')) {
            session()->forget('discount');
        }
        //delete from cart
        Cart::where('user_id', Auth::id())->where('user_ip', request()->ip())->delete();




        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

        //=======================


    }





    public function payViaAjax(Request $request)
    {

        # Here you have to receive all the order data to initate the payment.
        # Lets your oder trnsaction informations are saving in a table called "payments"
        # In payments table order uniq identity is "transaction_id","status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = '10'; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique



        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";


        #Before  going to initiate the payment order status need to update as Pending.
        $update_product = DB::table('payments')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'user_id' => auth()->id(),
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency'],
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    public function success(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();

        #Check order status in order tabel against the transaction id or order id.
        $order_detials = DB::table('payments')
            ->where('transaction_id', $tran_id)
            ->select('*')->first();

        if (Auth::guest() && $order_detials && $order_detials->user_id) {
            Auth::loginUsingId($order_detials->user_id);
        }

        $status_text = 'Unknown';
        $message = '';

        if ($order_detials && $order_detials->status == 'Pending') {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation == TRUE) {
                $updateData = ['status' => 'Processing'];

                if (empty($order_detials->business_id) && $request->filled('value_b')) {
                    $valueB = $request->input('value_b');
                    if (str_contains($valueB, 'business_id:')) {
                        $updateData['business_id'] = trim(explode(':', $valueB, 2)[1]);
                    }
                }

                if (empty($order_detials->seller_id) && $request->filled('value_a')) {
                    $valueA = $request->input('value_a');
                    if (str_contains($valueA, 'seller_id:')) {
                        $updateData['seller_id'] = trim(explode(':', $valueA, 2)[1]);
                    }
                }

                $update_product = DB::table('payments')
                    ->where('transaction_id', $tran_id)
                    ->update($updateData);

                // Save buyer information to seller_buyers table for business transactions
                if (strpos($order_detials->description, 'Payment to seller') !== false) {
                    $seller_id = $order_detials->seller_id ?: ($updateData['seller_id'] ?? null);
                    $business_id = $order_detials->business_id ?: ($updateData['business_id'] ?? null);
                    $quantity = $order_detials->quantity ?? 1;
                    $business = MyBusiness::find($business_id);

                    if ($seller_id && $business_id) {
                        $this->createSellerBuyerRecord([
                            'seller_id' => $seller_id,
                            'business_id' => $business_id,
                            'product_name' => $business?->product_name,
                            'buyer_id' => $order_detials->user_id,
                            'buyer_name' => $order_detials->name,
                            'buyer_email' => $order_detials->email,
                            'buyer_phone' => $order_detials->phone,
                            'buyer_address' => $order_detials->address,
                            'buyer_state' => $order_detials->state,
                            'buyer_post_code' => $order_detials->post_code,
                            'quantity' => $quantity,
                            'amount' => $amount,
                            'transaction_id' => $tran_id,
                            'payment_status' => 'pending',
                            'notes' => 'Payment successful - Business product purchase',
                        ], 'sslcommerz', [
                            'description' => $order_detials->description,
                        ]);
                    }
                }

                $status_text = 'Completed';
                $message = 'Your payment was successful and the order is now processing.';
            } else {
                $update_product = DB::table('payments')
                    ->where('transaction_id', $tran_id)
                    ->update(['status' => 'Failed']);

                $status_text = 'Failed';
                $message = 'Payment validation failed. Please try again or contact support.';
            }
        } elseif ($order_detials && ($order_detials->status == 'Processing' || $order_detials->status == 'Complete')) {
            $status_text = 'Completed';
            $message = 'This transaction was already processed successfully.';
        } else {
            $status_text = 'Invalid';
            $message = 'Invalid transaction. Please check your payment details and try again.';
        }

        return view('frontend.payment.result', [
            'tran_id' => $tran_id,
            'amount' => $amount,
            'currency' => $currency,
            'status_text' => $status_text,
            'message' => $message,
        ]);
    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('payments')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount', 'user_id')->first();

        if (Auth::guest() && $order_detials && $order_detials->user_id) {
            Auth::loginUsingId($order_detials->user_id);
        }

        $status_text = 'Failed';
        $message = 'Your payment was not completed. Please try again or contact support if the problem persists.';

        if (! $order_detials) {
            $status_text = 'Invalid';
            $message = 'Transaction not found. Please return to the store and try again.';
        } elseif ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            $status_text = 'Completed';
            $message = 'This transaction was already completed successfully.';
        } else {
            DB::table('payments')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Failed']);
        }

        return view('frontend.payment.result', [
            'tran_id' => $tran_id,
            'amount' => optional($order_detials)->amount,
            'currency' => optional($order_detials)->currency,
            'status_text' => $status_text,
            'message' => $message,
        ]);
    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('payments')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount', 'user_id')->first();

        if (Auth::guest() && $order_detials && $order_detials->user_id) {
            Auth::loginUsingId($order_detials->user_id);
        }

        $status_text = 'Canceled';
        $message = 'Your payment was cancelled. You can return to the marketplace and choose another option.';

        if (! $order_detials) {
            $status_text = 'Invalid';
            $message = 'Transaction not found. Please return to the store and try again.';
        } elseif ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            $status_text = 'Completed';
            $message = 'This transaction was already completed successfully.';
        } else {
            DB::table('payments')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Canceled']);
        }

        return view('frontend.payment.result', [
            'tran_id' => $tran_id,
            'amount' => optional($order_detials)->amount,
            'currency' => optional($order_detials)->currency,
            'status_text' => $status_text,
            'message' => $message,
        ]);
    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('payments')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == TRUE) {
                    $updateData = ['status' => 'Processing'];

                    if (empty($order_details->business_id) && $request->filled('value_b')) {
                        $valueB = $request->input('value_b');
                        if (str_contains($valueB, 'business_id:')) {
                            $updateData['business_id'] = trim(explode(':', $valueB, 2)[1]);
                        }
                    }

                    if (empty($order_details->seller_id) && $request->filled('value_a')) {
                        $valueA = $request->input('value_a');
                        if (str_contains($valueA, 'seller_id:')) {
                            $updateData['seller_id'] = trim(explode(':', $valueA, 2)[1]);
                        }
                    }

                    $update_product = DB::table('payments')
                        ->where('transaction_id', $tran_id)
                        ->update($updateData);

                    echo "Transaction is successfully Completed";
                } else {
                    /*
                    That means IPN worked, but Transation validation failed.
                    Here you need to update order status as Failed in order table.
                    */
                    $update_product = DB::table('payments')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Failed']);

                    echo "validation Fail";
                }
            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }
}
