<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\TeamController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\{CategoryController, ColorController};
use App\Http\Controllers\{ProductController, VariationsController, InventoryController, CartController};
use Illuminate\Support\Facades\Auth;

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
Route::get('/cartView', [CartController::class, 'cartView'])->name('cartView');
Route::get('/cartDelete/{cart_delete_id}', [CartController::class, 'cartDelete'])->name('cartDelete');
// cart

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
