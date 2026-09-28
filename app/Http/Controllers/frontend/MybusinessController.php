<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Business\MyBusiness;
use App\Models\Business\RatingBusiness;
use App\Models\Business\ReviewBusiness;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\Payment;
use App\Models\SellerBuyer;
use Carbon\Carbon;
use App\Services\FraudDetectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File; //for delete image
use Illuminate\Support\Facades\Redirect;

class MybusinessController extends Controller
{

    //================my_business===========================
    public function my_business()
    {
        $business = MyBusiness::where('status', 1)->latest()->paginate(16);
        return view('frontend.my_business.index', compact('business'));
    }

    public function add_business()
    {
        return view('frontend.my_business.add_business');
    }


    //==============store========================
    public function add_business_store(Request $request)
    {

        $business = new MyBusiness();

        if ($request->hasFile('image_one')) {
            $file = $request->file('image_one');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('img_DB/my_business/image_one/', $filename);
            $business->image_one = $filename;
        }
        if ($request->hasFile('image_two')) {
            $file = $request->file('image_two');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('img_DB/my_business/image_two/', $filename);
            $business->image_two = $filename;
        }
        if ($request->hasFile('image_three')) {
            $file = $request->file('image_three');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('img_DB/my_business/image_three/', $filename);
            $business->image_three = $filename;
        }
        if ($request->hasFile('image_four')) {
            $file = $request->file('image_four');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('img_DB/my_business/image_four/', $filename);
            $business->image_four = $filename;
        }

        $business->category = $request->category;
        $business->product_name = $request->product_name;
        $business->product_quantity = $request->product_quantity;
        $business->product_description = $request->product_description;
        $business->price = $request->price;

        $business->user_id = $request->User_id;
        $business->phone = $request->phone;
        $business->email = $request->email;
        $business->name = $request->name;
        $business->village = $request->village;
        $business->road = $request->road;
        $business->district = $request->district;
        $business->police_station = $request->police_station;
        $business->post_office = $request->post_office;
        $business->country = $request->country;
        $business->post_code = $request->post_code;
        $business->personal_description = $request->personal_description;

        $business->payment_gateway = $request->payment_gateway;
        $business->store_id = $request->store_id;
        $business->store_password = $request->store_password;
        $business->bkash_number = $request->bkash_number;
        $business->bank_name = $request->bank_name;
        $business->bank_account = $request->bank_account;
        $business->bank_routing = $request->bank_routing;

        $business->save();
        return Redirect('my_business')->with('status', 'Business Product Added Successfully');
    }


    //========================business_product_details======================
    public function business_product_details($id)
    {
        $business = MyBusiness::findOrFail($id);
        $lts_business = MyBusiness::where('status', 1)->latest()->get();

        //ratting
        $ratings = RatingBusiness::where('prod_id', $business->id)->get();
        $rating_sum = RatingBusiness::where('prod_id', $business->id)->sum('stars_rated');
        $user_rating = RatingBusiness::where('prod_id', $business->id)->where('user_id', Auth::id())->first();
        //review
        $reviews = ReviewBusiness::where('prod_id', $business->id)->join('users',  'review_businesses.user_id', 'users.id')->select('review_businesses.*', 'users.name')
            ->latest()->take(3)->get();
        //ratting
        if ($ratings->count() > 0) {
            $rating_value = $rating_sum / $ratings->count();
        } else {
            $rating_value = 0; //rating 0
        }

        return view('frontend.my_business.business_product_details', compact('business', 'lts_business', 'ratings', 'rating_sum', 'user_rating', 'rating_value', 'reviews'));
    }


    //=============profile==============================
    public function business_profile()
    {
        $business = MyBusiness::where('user_id', Auth::id())->latest()->paginate(16);
        return view('frontend.my_business.business_profile', compact('business'));
    }

    public function profile_business_product_details($id)
    {
        $business = MyBusiness::findOrFail($id);
        return view('frontend.my_business.profile_business_product_details', compact('business'));
    }

    public function edit_business($id)
    {
        $business = MyBusiness::findOrFail($id);
        return view('frontend.my_business.edit_profile_product', compact('business'));
    }

    public function add_business_update(Request $request, $id)
    {
        $business = MyBusiness::findOrFail($id);

        if ($request->hasFile('image_one')) {

            $path = 'img_DB/my_business/image_one/' . $business->image_one;
            if (File::exists($path)) //avobe import class
            {
                File::delete($path);
            }
            $file = $request->file('image_one');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('img_DB/my_business/image_one/', $filename);
            $business->image_one = $filename;
        }
        if ($request->hasFile('image_two')) {

            $path = 'img_DB/my_business/image_two/' . $business->image_one;
            if (File::exists($path)) //avobe import class
            {
                File::delete($path);
            }
            $file = $request->file('image_two');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('img_DB/my_business/image_two/', $filename);
            $business->image_two = $filename;
        }
        if ($request->hasFile('image_three')) {

            $path = 'img_DB/my_business/image_three/' . $business->image_one;
            if (File::exists($path)) //avobe import class
            {
                File::delete($path);
            }
            $file = $request->file('image_three');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('img_DB/my_business/image_three/', $filename);
            $business->image_three = $filename;
        }
        if ($request->hasFile('image_four')) {

            $path = 'img_DB/my_business/image_four/' . $business->image_one;
            if (File::exists($path)) //avobe import class
            {
                File::delete($path);
            }
            $file = $request->file('image_four');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('img_DB/my_business/image_four/', $filename);
            $business->image_four = $filename;
        }

        $business->category = $request->category;
        $business->product_name = $request->product_name;
        $business->product_quantity = $request->product_quantity;
        $business->product_description = $request->product_description;
        $business->price = $request->price;

        $business->user_id = $request->User_id;
        $business->phone = $request->phone;
        $business->email = $request->email;
        $business->name = $request->name;
        $business->village = $request->village;
        $business->road = $request->road;
        $business->district = $request->district;
        $business->police_station = $request->police_station;
        $business->post_office = $request->post_office;
        $business->country = $request->country;
        $business->post_code = $request->post_code;
        $business->personal_description = $request->personal_description;

        $business->payment_gateway = $request->payment_gateway;
        $business->store_id = $request->store_id;
        $business->store_password = $request->store_password;
        $business->bkash_number = $request->bkash_number;
        $business->bank_name = $request->bank_name;
        $business->bank_account = $request->bank_account;
        $business->bank_routing = $request->bank_routing;

        $business->update();
        return Redirect('profile_business_product_details/' . $business->id)->with('status', 'Business Product Updated Successfully');
    }

    public function delete_business($id)
    {
        MyBusiness::find($id)->delete();
        return Redirect('business_profile')->with('status', 'Business Product Deleted Successfully');
    }

    public function business_zero($id)
    {
        $business = MyBusiness::findOrFail($id);
        $business->status= '0';
        $business->save();
        return redirect()->back()->with('status','Business Product Status Inactive.');
    }

    public function business_one($id)
    {
        $business = MyBusiness::findOrFail($id);
        $business->status= '1';
        $business->save();
        return redirect()->back()->with('status','Business Product Status Active.');
    }




    //=======================Rating==============================
    public function business_add_rating(Request $request)
    {
        $stars_rated = $request->input('product_rating');
        $business_product_id = $request->input('business_product_id');

        $product_check = MyBusiness::where('id', $business_product_id)->where('status', '1')->first();
        if ($product_check) {

            $existing_rating = RatingBusiness::where('user_id', Auth::id())->where('prod_id', $business_product_id)->first();
            if ($existing_rating) {
                $existing_rating->stars_rated = $stars_rated;
                $existing_rating->update();
            } else {
                RatingBusiness::create([
                    'user_id' => Auth::id(),
                    'prod_id' => $business_product_id,
                    'stars_rated' => $stars_rated
                ]);
            }
            return redirect()->back()->with('status', "Thank you for Rating this product");
        } else {
            return redirect()->back()->with('status', "The link you followed was broken");
        }
    }


    //=======================Review======================================
    public function reviewadd($id)
    {
        $business = MyBusiness::findOrFail($id);
        return view('frontend.my_business.review.review', compact('business'));
    }

    public function reviewcreate(Request $request)
    {
        $business_product_id = $request->input('business_product_id');
        $user_review = $request->input('user_review');
        $new_review = ReviewBusiness::create([
            'user_id' => Auth::id(),
            'prod_id' => $business_product_id,
            'user_review' => $user_review
        ]);

        $business = MyBusiness::where('id', $business_product_id)->where('status', '1')->first();
        $id = $business->id;
        if ($new_review) {
            return redirect('business_product_details/' . $id)->with('status', "Thank you for writing a review");
            //return redirect()->to('add-review/'.$product_id)->with('status', "Thank you for writing a review");
        }
    }

    public function editreview($id)
    {
        $business_review = ReviewBusiness::find($id);

        return view('frontend.my_business.review.edit', compact('business_review'));
    }

    public function update(Request $request, $id)
    {
        $review = ReviewBusiness::find($id);
        $review->user_review = $request->user_review;
        $review->update();

        $business_product_id = $request->business_product_id;
        $business = MyBusiness::where('id', $business_product_id)->where('status', '1')->first();
        return redirect('business_product_details/' . $business->id)->with('status', "Your review updated");
    }



    public function Delete($id)
    {
        ReviewBusiness::find($id)->delete();
        return Redirect()->back()->with('status', 'Review deleted successfully');
    }

    public function review_more_business($id)
    {
        $business = MyBusiness::findOrFail($id);
        $review = ReviewBusiness::where('prod_id', $business->id)
        ->join('users',  'review_businesses.user_id', 'users.id')->select('review_businesses.*', 'users.name')
        ->latest()->paginate(10);
        return view('frontend.my_business.review.more_review', compact('review', 'business'));
    }

    //=======================Business Buyers======================================
    public function my_buyers()
    {
        // Get all buyers who purchased from the authenticated seller's active business products
        $buyers = \App\Models\SellerBuyer::where('seller_id', Auth::id())
            ->whereHas('business')
            ->with('business', 'buyer')
            ->latest()
            ->paginate(15);

        return view('frontend.my_business.my_buyers', compact('buyers'));
    }

    public function buyers_by_product($business_id)
    {
        // Get buyers for a specific business product
        $business = MyBusiness::where('id', $business_id)->where('user_id', Auth::id())->firstOrFail();

        $buyers = \App\Models\SellerBuyer::where('seller_id', Auth::id())
            ->where('business_id', $business_id)
            ->with('buyer')
            ->latest()
            ->paginate(15);

        return view('frontend.my_business.buyers_by_product', compact('buyers', 'business'));
    }

    public function buyer_details($id)
    {
        // Get detailed information about a specific buyer
        $buyer = \App\Models\SellerBuyer::where('id', $id)
            ->where('seller_id', Auth::id())
            ->with('business', 'buyer')
            ->firstOrFail();

        // compute fraud score for this buyer transaction (lightweight, rule-based)
        $fraudService = new FraudDetectionService();
        $fraudResult = $fraudService->score([
            'user_id' => $buyer->buyer_id ?? null,
            'amount' => (float) ($buyer->amount ?? 0),
            'address' => $buyer->buyer_address ?? '',
            'state' => $buyer->buyer_state ?? '',
            'post_code' => $buyer->buyer_post_code ?? '',
            'name' => $buyer->buyer_name ?? '',
            'ip' => null,
        ]);

        return view('frontend.my_business.buyer_details', compact('buyer', 'fraudResult'));
    }

    public function approve_buyer($id)
    {
        $buyer = SellerBuyer::where('id', $id)
            ->where('seller_id', Auth::id())
            ->firstOrFail();

        if ($buyer->payment_status === 'completed') {
            return Redirect::back()->with('status', 'This order is already approved.');
        }

        $buyer->payment_status = 'completed';
        $buyer->notes = trim(($buyer->notes ? $buyer->notes . ' | ' : '') . 'Seller approved on ' . Carbon::now()->format('d M Y h:i A'));
        $buyer->save();

        if ($buyer->transaction_id) {
            $payment = Payment::where('transaction_id', $buyer->transaction_id)->first();
            if ($payment) {
                $payment->status = 'Completed';
                $payment->save();

                if ($payment->order_id) {
                    OrderPayment::where('id', $payment->order_id)->update(['status' => 1]);
                    Order::where('id', $payment->order_id)->update(['status' => 1]);
                }
            }
        }

        return Redirect::back()->with('status', 'Buyer order approved successfully.');
    }
}
