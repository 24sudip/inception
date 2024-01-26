<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\ProductGallery;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        return view('frontend.index', [
            'products'=>Product::latest()->get(),
            'categorys'=>Category::all(),
        ]);
    }
    public function productDetails($id)
    {
        // echo $id;
        $products = Product::findOrFail($id);
        $inventories = Inventory::where('product_id', $products->id)->get();
        $product_gal = ProductGallery::where('product_id', $products->id)->get();
        $related_products = Product::where('product_category', $products->product_category)->where('id','!=',$id)->get();
        return view('frontend.productDetails', compact('products','related_products','inventories','product_gal'));
    }
    public function about()
    {
        return view('frontend.about');
    }
    public function accounts()
    {
        return view('frontend.accounts');
    }
    public function customerRegistration(Request $request)
    {
        // return $request;
        // $validate = Validator::make(Input::all(), [
        //     'g-recaptcha-response' => 'required|captcha'
        // ]);

        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required|confirmed',
            'password_confirmation'=>'required',
            'g-recaptcha-response' => 'required|captcha'
        ]);
        User::insert([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'role'=>'customer',
            'created_at'=>Carbon::now(),
        ]);
        return back()->with('registerSuccess','Register Done Successfully');
    }
    public function customerLogin(Request $request)
    {
        // return $request;
        if (Auth::attempt(['email'=>$request->email, 'password'=>$request->password])) {

            return redirect(route('customer_home'));
        }
    }
    public function githubRedirect()
    {
        return Socialite::driver('github')->redirect();
    }
    public function githubCallback()
    {
        $githubUser = Socialite::driver('github')->user();

        $user = User::updateOrCreate([
            'email' => $githubUser->email,
        ], [
            'name' => $githubUser->name,
            'email' => $githubUser->email,
            'password'=>bcrypt(213456879),
            'role'=>'customer',
            'created_at'=>Carbon::now(),
        ]);
        Auth::login($user);

        return redirect(route('customer_home'));
    }
}
