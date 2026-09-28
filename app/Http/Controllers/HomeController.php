<?php

namespace App\Http\Controllers;

use App\Models\Business\MyBusiness;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\ProductRecommendationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected ProductRecommendationService $recommendationService;

    public function __construct(ProductRecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    // after login -> user & admin
    public function redirect()
    {
        if(Auth::id())
        {
            if(Auth::user()->usertype=='0')// 0=>Frontend dashboard home
            {
                $products = Product::where('status',1)->latest()->get();
                //$lts_p = Product::where('status',1)->latest()->limit(3)->get();
                $products_old = Product::where('status',1)->paginate(8);
                $categories = Category::where('status',1)->latest()->get();
                $lts_business = MyBusiness::where('status', 1)->latest()->get();
                $topRatedProducts = Product::where('status',1)
                    ->withAvg('ratings', 'stars_rated')
                    ->withCount('ratings')
                    ->whereHas('ratings')
                    ->orderByDesc('ratings_avg_stars_rated')
                    ->orderByDesc('ratings_count')
                    ->take(4)
                    ->get();
                $topRatedBusiness = MyBusiness::where('status', 1)
                    ->withAvg('ratings', 'stars_rated')
                    ->withCount('ratings')
                    ->whereHas('ratings')
                    ->orderByDesc('ratings_avg_stars_rated')
                    ->orderByDesc('ratings_count')
                    ->take(4)
                    ->get();

                $recommendedProducts = $this->buildRecommendedProducts();

                return view('frontend.index', compact('products','categories','products_old','lts_business','topRatedProducts','topRatedBusiness','recommendedProducts'));
            }else
            {
            // =================== Order ==========================
                $orders = Order::where('status',0)->latest()->paginate(10);
                return view('admin.order.index',compact('orders'));
            }
        }
        else
        {
            return redirect()->back();
        }

    }






public function index()
{
       $products = Product::where('status',1)->latest()->get();
        //$lts_p = Product::where('status',1)->latest()->limit(3)->get();
        $products_old = Product::where('status',1)->paginate(8);
        $categories = Category::where('status',1)->latest()->get();
        $lts_business = MyBusiness::where('status', 1)->latest()->get();
        $topRatedProducts = Product::where('status',1)
            ->withAvg('ratings', 'stars_rated')
            ->withCount('ratings')
            ->whereHas('ratings')
            ->orderByDesc('ratings_avg_stars_rated')
            ->orderByDesc('ratings_count')
            ->take(4)
            ->get();
        $topRatedBusiness = MyBusiness::where('status', 1)
            ->withAvg('ratings', 'stars_rated')
            ->withCount('ratings')
            ->whereHas('ratings')
            ->orderByDesc('ratings_avg_stars_rated')
            ->orderByDesc('ratings_count')
            ->take(4)
            ->get();

    $recommendedProducts = $this->buildRecommendedProducts();

    return view('frontend.index', compact('products','categories','products_old','lts_business','topRatedProducts','topRatedBusiness','recommendedProducts'));
}

    protected function buildRecommendedProducts()
    {
        $products = Product::where('status', 1)->get();

        if (!Auth::check()) {
            return $products->take(4);
        }

        $userId = Auth::id();
        $interactedProductIds = collect();
        $preferredCategoryIds = collect();

        $carts = Cart::where('user_id', $userId)->with('product')->get();
        if ($carts->isNotEmpty()) {
            $interactedProductIds = $interactedProductIds->merge($carts->pluck('product_id'));
            $preferredCategoryIds = $preferredCategoryIds->merge($carts->pluck('product.category_id')->filter());
        }

        $orders = Order::where('user_id', $userId)->get();
        if ($orders->isNotEmpty()) {
            $orderIds = $orders->pluck('id');
            $orderedProducts = OrderItem::whereIn('order_id', $orderIds)->pluck('product_id');
            $interactedProductIds = $interactedProductIds->merge($orderedProducts);

            $orderedCategories = Product::whereIn('id', $orderedProducts)
                ->pluck('category_id');
            $preferredCategoryIds = $preferredCategoryIds->merge($orderedCategories);
        }

        $interactedProductIds = $interactedProductIds->filter()->unique()->values()->all();
        $preferredCategoryIds = $preferredCategoryIds->filter()->unique()->values()->all();

        return $this->recommendationService->recommend($products, $interactedProductIds, $preferredCategoryIds);
    }
}


