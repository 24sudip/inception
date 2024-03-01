<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    function checkout()
    {
        $carts = Cart::where('customer_id', Auth::id())->get();
        return view('frontend.checkout',[
            'carts'=>$carts,
        ]);
    }

    function OrderStore(Request $request)
    {
        Order::insert([
            'customer_id'=>Auth::id(),
            'order_id'=>uniqid(),
            'name'=>$request->name,
            'email'=>$request->email,
            'company'=>$request->company,
            'phone'=>$request->phone,
            'country'=>$request->country,
            'city'=>$request->city,
            'address'=>$request->address,
            'notes'=>$request->notes,
            'discount'=>$request->discount,
            'charge'=>$request->charge,
            'total'=>$request->charge+$request->sub_total,
            'created_at'=>now(),
        ]);
        return redirect()->route('order.success');
    }

    function OrderSuccess()
    {
        return view('frontend.orderSuccess');
    }
}
