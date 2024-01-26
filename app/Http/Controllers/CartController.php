<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
    public function cart(Request $request)
    {
        // return $request;
        Cart::insert([
            'product_id'=>$request->product_id,
            'user_id'=>$request->user_id,
            'size_id'=>$request->size_id,
            'color_id'=>$request->color_id,
            'quantity'=>$request->quantity,
            'created_at'=>now(),
        ]);
        return back()->with('cartInsertMsg','Cart Added Successfully');
    }
}
