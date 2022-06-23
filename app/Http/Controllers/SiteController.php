<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $main_cat = Category::withCount('child')->WhereNull('parent_id')->take(11)->get();
        $latest_product = Product::with('category')->OrderByDesc('created_at')->limit(5)->get();
        return view('site.index', compact('main_cat','latest_product'));
    }
    public function category($id)
    {
        $category = Category::findOrFail($id);
        return view('site.category',compact('category'));
    }
    public function product($id)
    {
        $product = Product::with('reviews')->findOrFail($id);
        return view('site.product',compact('product'));
    }
    public function shop()
    {
        $products = Product::paginate(8);
        return view('site.shop',compact('products'));
    }
    public function add_review(Request $req)
    {
        Review::create([
            'user_id'=> Auth::id(),
            'product_id'=> $req->product_id,
            'comment'=> $req->comment,
            'start'=>$req->star
        ]);
        return redirect()->back();
    }
}
