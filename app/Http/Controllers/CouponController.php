<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function coupon()
    {
        $coupons = Coupon::all();
        return view('layouts.dashboard.coupon',[
            'coupons'=>$coupons,
        ]);
    }

    public function couponAdd(Request $request)
    {
        $request->validate([
            'coupon_name'=>'required',
            'discount'=>'required',
            'coupon_date'=>'required',
        ]);
        Coupon::insert([
            'coupon_name'=>$request->coupon_name,
            'type'=>$request->type,
            'discount'=>$request->discount,
            'coupon_date'=>$request->coupon_date,
            'created_at'=>now(),
        ]);
        return back()->with('cpnAdMsg','Coupon Added Successfully');
    }

    public function couponDelete($id)
    {
        Coupon::find($id)->delete();
        return back();
    }
}
