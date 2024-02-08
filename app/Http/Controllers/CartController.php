<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function cart(Request $request, $id)
    {
        // return $request;
        Cart::insert([
            'customer_id'=>Auth::id(),
            'product_id'=>$id,
            'color_id'=>$request->color_id,
            'size_id'=>$request->size_id,
            'quantity'=>$request->quantity,
            'created_at'=>now(),
        ]);
        return back()->with('cartInsertMsg','Cart Added Successfully');
    }
    
    public function cartView()
    {
        return view('frontend.cartView');
    }

    public function cartDelete($cart_delete_id)
    {
        Cart::find($cart_delete_id)->delete();
        return back();
    }

    public function cartUpdate(Request $request)
    {
        foreach ($request->quantity as $cart_id => $quantity) {
            Cart::find($cart_id)->update([
                'quantity'=>$quantity,
            ]);
        }
        return back()->with('crtUpdtMsg','Cart Updated Successfully');
    }
}
