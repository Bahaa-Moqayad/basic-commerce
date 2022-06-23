<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('category')->paginate(10);
        return view('admin.products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::select(['id','name'])->get();
        return view('admin.products.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'image'=>'required',
            'description'=>'required',
            'price'=>'required',
            'quantity'=>'required',
            'category_id'=>'required'
        ]);
        $new_image = rand().rand().time().$request->file('image')->getClientOriginalName();
        $new_image= str_replace(' ','',$new_image);
        $new_image= strtolower($new_image);
        $request->file('image')->move(public_path('uploads/images'),$new_image);

        Product::create([
            'name'=>$request->name,
            'image'=>$new_image,
            'description'=>$request->description,
            'price'=>$request->price,
            'sale_price'=>$request->sale_price,
            'quantity'=>$request->quantity,
            'category_id'=>$request->category_id,
        ]);
        return redirect()->route('admin.products.index')->with('msg','Product Created Succesfully')->with('type','success');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::select(['id','name']);
        return view('admin.products.edit',compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'image'=>'nullable',
            'description'=>'required',
            'price'=>'required',
            'quantity'=>'required',
            'category_id'=>'required'
        ]);
        $product = Product::findOrFail($id);
        $new_image= $product->image;
        if($request->hasFile('image')){
            $new_image = rand().rand().time().$request->file('image')->getClientOriginalName();
            $new_image= str_replace(' ','',$new_image);
            $new_image= strtolower($new_image);
        $request->file('image')->move(public_path('uploads/images'),$new_image);
        }

        Product::update([
            'name'=>$request->name,
            'image'=>$new_image,
            'description'=>$request->description,
            'price'=>$request->price,
            'sale_price'=>$request->sale_price,
            'quantity'=>$request->quantity,
            'category_id'=>$request->category_id,
        ]);
        return redirect()->route('admin.products.index')->with('msg','Product Updated Succesfully')->with('type','info');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if(file_exists(public_path('uploads/images/'. $product->image))){
            File::delete(public_path('uploads/images/'. $product->image));
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('msg','Product Deleted Succesfully')->with('type','danger');
    }
}
