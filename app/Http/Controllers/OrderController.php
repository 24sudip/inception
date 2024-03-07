<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    function orders()
    {
        $orders = Order::all();
        return view('layouts.dashboard.orders',[
            'orders'=>$orders,
        ]);
    }
    function orderStatus(Request $request, $order_id)
    {
        // echo "<h1>".$request->status."</h1>";
        // echo "<h1>".$order_id."</h1>";
        Order::find($order_id)->update([
            'status'=>$request->status,
        ]);
        return back();
    }
}
