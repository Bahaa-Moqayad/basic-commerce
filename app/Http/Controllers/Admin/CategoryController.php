<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with('parent')->withCount('products')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.categories.create',compact('categories'));
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
            'parent_id'=>'nullable|exists:categories,id',
        ]);

        $new_image = rand().rand().time().$request->file('image')->getClientOriginalName();
        $new_image= str_replace(' ','',$new_image);
        $new_image= strtolower($new_image);
        $request->file('image')->move(public_path('uploads/images'),$new_image);

        Category::create([
            'name'=>$request->name,
            'image'=>$new_image,
            'parent_id'=>$request->parent_id,
        ]);

        return redirect()->route('admin.categories.index')->with('msg','Category Created Succesfully')->with('type','success');
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
        $category = Category::findOrFail($id);
        $categories = Category::all()->where('id','<>',$category->id);
        return view('admin.categories.edit',compact('category', 'categories'));
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
        $category = Category::findOrFail($id);
        $request->validate([
            'name'=>'required',
            'image'=>'nullable',
            'parent_id'=>'nullable|exists:categories,id',
        ]);
        $new_image = $category->image;
        if($request->hasFile('image')){
            $new_image = rand().rand().time().$request->file('image')->getClientOriginalName();
            $new_image= str_replace(' ','',$new_image);
        $new_image= strtolower($new_image);
            $request->file('image')->move(public_path('uploads/images'),$new_image);
        }
        $category->update([
            'name'=>$request->name,
            'image'=>$new_image,
            'parent_id'=>$request->parent_id,
        ]);
        return redirect()->route('admin.categories.index')->with('msg','Category Updated Succesfully')->with('type','info');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if(file_exists(public_path('uploads/images/'. $category->image))){
            File::delete(public_path('uploads/images/'. $category->image));
        }
        Category::where('parent_id',$category->id)->update([
            'parent_id'=>null
        ]);
        $category->delete();
        return redirect()->route('admin.categories.index')->with('msg','Category Deleted Succesfully')->with('type','danger');
    }
}
