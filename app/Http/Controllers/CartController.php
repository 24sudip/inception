<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;
use App\Models\Coupon;
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

    public function cartView(Request $request)
    {
        $coupon_name = $request->coupon_name;
        $msg = "";
        $discount = 0;
        $type = "";
        if ($coupon_name == "") {
            $msg = "";
        } else if (Coupon::where('coupon_name', $coupon_name)->exists()) {
            $msg = "Coupon Added. Don't Go Back";
            $discount = Coupon::where('coupon_name', $coupon_name)->first()->discount;
            $type = Coupon::where('coupon_name', $coupon_name)->first()->type;
        } else {
            $msg = "Invalid Coupon. Go Back";
        }
        return view('frontend.cartView',[
            'discount'=>$discount,
            'msg'=>$msg,
            'type'=>$type,
        ]);
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
