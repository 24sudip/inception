<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\TeamController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\{CategoryController, ColorController, CouponController, CheckoutController, OrderController};
use App\Http\Controllers\{ProductController, VariationsController, InventoryController, CartController};
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SslCommerzPaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('frontend.index');
// })->name('customer_home');
Route::get('/', [FrontendController::class, 'index'])->name('customer_home');
// Route::get('/service', function () {
//     return view('service');
//     // echo "This Is service Page";
// });
// Route::get('/service', [TeamController::class, 'service']);
// Route::get('/teams', [TeamController::class, 'team']);
// Route::post('/teamInsert', [TeamController::class, 'teamInsert']);
// Route::get('/teamDelete/{id}', [TeamController::class, 'teamDelete']);

// FrontendController Part
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/accounts', [FrontendController::class, 'accounts'])->name('accounts');
Route::post('/customerRegistration', [FrontendController::class, 'customerRegistration'])->name('customerRegistration');
Route::post('/customerLogin', [FrontendController::class, 'customerLogin'])->name('customerLogin');

Route::get('/githubRedirect', [FrontendController::class, 'githubRedirect'])->name('githubRedirect');
Route::get('/githubCallback', [FrontendController::class, 'githubCallback'])->name('githubCallback');
// FrontendController Part

Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
Route::post('/profile/photo/upload', [ProfileController::class, 'profile_photo_upload'])->name('profilePhoto');
Route::post('/password/change', [ProfileController::class, 'password_change']);

// Category part
Route::resource('category', CategoryController::class);
// Category part

// Product part
Route::resource('product', ProductController::class);
// Product part

// VariationsController Routes
Route::resource('variation', VariationsController::class);
Route::get('/productInventory/{id}', [InventoryController::class, 'inventory'])->name('product.inventory');
Route::post('/inventoryStore/{id}', [InventoryController::class, 'inventoryStore'])->name('inventory.store');
Route::get('color', [ColorController::class, 'index'])->name('color.index');
// VariationsController Routes

// Product Details
Route::get('/productDetails/{id}', [FrontendController::class, 'productDetails'])->name('productDetails');
// Product Details

// cart
Route::post('/cart/{id}', [CartController::class, 'cart'])->name('cart');
Route::get('/cartDelete/{cart_delete_id}', [CartController::class, 'cartDelete'])->name('cartDelete');
Route::get('/cartView', [CartController::class, 'cartView'])->name('cartView');
Route::post('/cartUpdate', [CartController::class, 'cartUpdate'])->name('cartUpdate');
// cart

// Coupon
Route::get('/coupon', [CouponController::class, 'coupon'])->name('coupon');
Route::post('/couponAdd', [CouponController::class, 'couponAdd'])->name('couponAdd');
Route::get('/coupon/delete/{id}', [CouponController::class, 'couponDelete'])->name('coupon.delete');
// Coupon

// Checkout
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::post('/order/store', [CheckoutController::class, 'OrderStore'])->name('order.store');
Route::get('/order/success', [CheckoutController::class, 'OrderSuccess'])->name('order.success');
// Checkout

// Order
Route::get('/orders', [OrderController::class, 'orders'])->name('orders');
Route::post('/order/status/{order_id}', [OrderController::class, 'orderStatus'])->name('order.status');
// Order

// SSLCOMMERZ Start
// Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
// Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::get('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

// Route::post('https://sandbox.sslcommerz.com/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END

Auth::routes();
//Route::get('/register', function () {
//    return view('frontend.error');
//});
//Route::get('/login', function () {
//    return view('frontend.error');
//});
// Auth::routes();
//Route::get('/admin/login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
//Route::post('/admin/login', 'App\Http\Controllers\Auth\LoginController@login');
//Route::post('/admin/logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
//Route::get('/admin/register', 'App\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
//Route::post('/admin/register', 'App\Http\Controllers\Auth\RegisterController@register');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// $this->get('admin/password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//  $this->post('admin/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
// $this->get('admin/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
// $this->post('admin/password/reset', 'Auth\ResetPasswordController@reset');
