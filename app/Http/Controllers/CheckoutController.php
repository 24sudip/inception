<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
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
        $order_id = uniqid();
        if ($request->payment_method == 1) {
            Order::insert([
                'customer_id'=>Auth::id(),
                'order_id'=>$order_id,
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
                'total'=>$request->charge+$request->total,
                'created_at'=>now(),
            ]);
            $carts = Cart::where('customer_id', Auth::id())->get();
            foreach ($carts as $cart) {
                OrderProduct::insert([
                    'customer_id'=>Auth::id(),
                    'order_id'=>$order_id,
                    'product_id'=>$cart->product_id,
                    'color_id'=>$cart->color_id,
                    'size_id'=>$cart->size_id,
                    'quantity'=>$cart->quantity,
                ]);
            }
            return redirect()->route('order.success');
        } else {
            // echo "<h1>SSL</h1>";
            $data = $request->all();
            return redirect('/pay')->with('data', $data);
        }
    }

    function OrderSuccess()
    {
        return view('frontend.orderSuccess');
    }
}
