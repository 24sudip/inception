<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\ProductGallery;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('layouts.dashboard.product.index', [
            'products'=>Product::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return Category::get(['id', 'category_name']);
        return view('layouts.dashboard.product.create', [
            'categorys'=>Category::get(['id', 'category_name']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'name'=>'required',
            'product_category'=>'required',
            'purchase_price'=>'required',
            'regular_price'=>'required',
            'description'=>'required',
            'long_description'=>'required',
            'additional_information'=>'required',
        ]);

        $product = Product::create($request->except('_token', 'product_galleries')+[
            'thumbnail'=>'anything photo',
        ]);
        foreach ($request->product_galleries as $product_gallery) {
            $rand_id = rand(100000, 999999);
            $new_name = $rand_id . time() . "." . $product_gallery->getClientOriginalExtension();
            $img =Image::make($product_gallery)->resize(680, 680);
            $img->save(base_path('public/uploads/product_gallery/' . $new_name), 100);
            ProductGallery::create([
                'multi_img'=>$new_name,
                'product_id'=>$product->id,
                'created_at'=>Carbon::now(),
            ]);
        }

        if ($request->hasFile('thumbnail')) {

            $new_name = $product->id . Carbon::now()->format('Y-m-d') . "."
            . $request->file('thumbnail')->getClientOriginalExtension();

            $img =Image::make($request->file('thumbnail'))->resize(800, 609);
            $img->save(base_path('public/uploads/product_photo/' . $new_name), 100);
            Product::find($product->id)->update([
                'thumbnail'=>$new_name,
            ]);
        }
        return back()->with('productAddMsg','Product Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return view('layouts.dashboard.product.edit', compact('product'), [
            'categorys'=>Category::get(['id', 'category_name']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_category'=>'required'
        ]);
        Product::find($id)->update([
            'name'=>$request->name,
            'product_category'=>$request->product_category,
            'purchase_price'=>$request->purchase_price,
            'regular_price'=>$request->regular_price,
            'discount_price'=>$request->discount_price,
            'description'=>$request->description,
            'long_description'=>$request->long_description,
            'additional_information'=>$request->additional_information,
        ]);
        if ($request->hasFile('thumbnail')) {

            unlink(base_path('public/uploads/product_photo/' . Product::find($id)->thumbnail));
            $new_name = $id . Carbon::now()->format('Y-m-d') . "."
            . $request->file('thumbnail')->getClientOriginalExtension();

            $img =Image::make($request->file('thumbnail'))->resize(800, 609);
            $img->save(base_path('public/uploads/product_photo/' . $new_name), 100);
            Product::find($id)->update([
                'thumbnail'=>$new_name,
            ]);
        }

        return back()->with('productEditSuccess','Product has been Edited Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return back();
    }
}
