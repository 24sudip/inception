<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function coupon()
    {
        return view('layouts.dashboard.coupon');
    }

    public function couponAdd(Request $request)
    {
        $request->validate([
            'coupon_name'=>'required',
            'coupon_date'=>'required',
        ]);
        Coupon::insert([
            'coupon_name'=>$request->coupon_name,
            'coupon_percentage'=>$request->coupon_percentage,
            'coupon_fixed'=>$request->coupon_fixed,
            'coupon_date'=>$request->coupon_date,
            'created_at'=>now(),
        ]);
        return back()->with('cpnAdMsg','Coupon Added Successfully');
    }
}
