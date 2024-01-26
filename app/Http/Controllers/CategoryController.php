<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('layouts.dashboard.category.index', [
            'categorys'=>Category::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('layouts.dashboard.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
        //  $request->category_photo
        $request->validate([
            'category_name'=>'required',
            'category_slug'=>'required',
            'category_photo'=>'required|image',
        ]);
        $time = Carbon::now()->toTimeString();
        $d = explode(':', $time);
        $d_two = $d[0].$d[1].$d[2];

        $new_name = Auth::user()->id ."-". Carbon::now()->format('Y-m-d') ."-".$d_two. "."
        . $request->file('category_photo')->getClientOriginalExtension();

        $img =Image::make($request->file('category_photo'))->resize(200, 256);
        $img->save(base_path('public/uploads/category_photo/' . $new_name), 80);

        $slug = Str::slug($request->category_slug);
        // echo $slug;
        Category::insert([
            'category_name' => $request->category_name,
            'category_slug' => $slug,
            'category_photo' => $new_name,
            'created_at' => Carbon::now(),
        ]);
        // return back()->with('categorySuccess','Category Added Successfully');
        return redirect('category');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('layouts.dashboard.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::find($id);
        return view('layouts.dashboard.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        Category::find($id)->update([
            'category_name'=>$request->category_name,
            'category_slug'=>$request->category_slug,
            // $request->category_photo,
        ]);
        if ($request->hasFile('category_photo')) {
            // echo "Photo Ache";
            unlink(base_path('public/uploads/category_photo/' . Category::find($id)->category_photo));
            $time = Carbon::now()->toTimeString();
            $d = explode(':', $time);
            $d_two = $d[0].$d[1].$d[2];

            $new_name = Auth::user()->id ."-". Carbon::now()->format('Y-m-d') ."-".$d_two. "."
            . $request->file('category_photo')->getClientOriginalExtension();

            $img =Image::make($request->file('category_photo'))->resize(200, 256);
            $img->save(base_path('public/uploads/category_photo/' . $new_name), 80);
            Category::find($id)->update([
                'category_photo'=>$new_name,
            ]);
        }
        // else {
        //     echo "Photo Nai";
        // }
        return back()->with('categoryEditSuccess','Category has been Edited Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return back();
    }
}
