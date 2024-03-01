@extends('frontend.frontendMaster')

@section('content')
<!-- cart_section - start
================================================== -->
<section class="cart_section section_space">
    <div class="container">

        <div class="cart_table">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Remove</th>
                    </tr>
                </thead>
                @php
                    $total = 0;
                @endphp
                <tbody>
                    @foreach (App\Models\Cart::where('customer_id', Auth::id())->get() as $cart)
                    <tr>
                        <td>
                            <div class="cart_product">
                                <img src="{{ asset('uploads/product_photo') }}/{{ $cart->relation_to_product->thumbnail }}" alt="image_not_found">
                                <h3><a href="shop_details.html">{{ $cart->relation_to_product->name }}</a></h3>
                            </div>
                        </td>
                        <td class="text-center">
                            @if ($cart->relation_to_product->discount_price)
                            <span class="price_text">${{ $cart->relation_to_product->discount_price }}</span>
                            @else
                            <span class="price_text">${{ $cart->relation_to_product->regular_price }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <form action="#">
                                <div class="quantity_input">
                                    <button type="button" class="input_number_decrement btn_d">
                                        <i class="fal fa-minus"></i>
                                    </button>
                                    <input class="input_number_2" type="text" value="{{ $cart->quantity }}"
                                    name="quantity[{{ $cart->id }}]">
                                    <button type="button" class="input_number_increment btn_i">
                                        <i class="fal fa-plus"></i>
                                    </button>
                                </div>
                            </form>
                        </td>
                        <td class="text-center">
                            @if ($cart->relation_to_product->discount_price)
                            <span class="price_text">${{ $cart->relation_to_product->discount_price * $cart->quantity }}</span>
                            @else
                            <span class="price_text">${{ $cart->relation_to_product->regular_price * $cart->quantity }}</span>
                            @endif
                        </td>
                        <td class="text-center"><a href="{{ route('cartDelete', $cart->id) }}" type="button" class="remove_btn"><i class="fal fa-trash-alt"></i></a></td>
                    </tr>
                    @php
                        if ($cart->relation_to_product->discount_price) {
                            $product_price = $cart->relation_to_product->discount_price;
                        } else {
                            $product_price = $cart->relation_to_product->regular_price;
                        }
                        $total += $product_price * $cart->quantity;
                    @endphp
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="cart_btns_wrap">
            <div class="row">
                <div class="col col-lg-6">
                    @if ($msg)
                    <div class="alert alert-primary">{{ $msg }}</div>
                    @else
                    <p>Type Coupon Name</p>
                    @endif
                    <form action="" method="GET">
                        <div class="coupon_form form_item mb-0">
                            <input type="text" name="coupon_name" placeholder="Coupon Code">
                            <button type="submit" class="btn btn_dark">Apply Coupon</button>
                            <div class="info_icon">
                                <i class="fas fa-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" title="Your Info Here"></i>
                            </div>
                        </div>
                    </form>
                </div>
                @php
                    $sub_total = 0;
                    if ($type == 1) {
                        $sub_total = $total - $discount;
                    } else if($type == 2) {
                        $sub_total = $total - $total * $discount / 100;
                    } else {
                        $sub_total = $total;
                    }
                @endphp
                <div class="col col-lg-6">
                    <form action="{{ route('cartUpdate') }}" method="post">
                        @csrf
                        @foreach (App\Models\Cart::where('customer_id', Auth::id())->get() as $cart)
                        <input class="input_number_2" type="text" hidden value="{{ $cart->quantity }}"
                        name="quantity[{{ $cart->id }}]">
                        @endforeach

                        @if (session('crtUpdtMsg'))
                        <div class="alert alert-success">{{ session('crtUpdtMsg') }}</div>
                        @endif
                        <ul class="btns_group ul_li_right">
                            <li><button class="btn border_black">Update Cart</button></li>
                        </ul>
                    </form>
                    <ul class="btns_group ul_li_right">
                        @php
                            session([
                                'sub_total'=>$sub_total,
                            ]);
                        @endphp
                        <li><a class="btn btn_dark" href="{{ route('checkout') }}">Prceed To Checkout</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- <div class="col col-lg-6">
                <div class="calculate_shipping">
                    <h3 class="wrap_title">Calculate Shipping <span class="icon"><i class="far fa-arrow-up"></i></span></h3>
                    <form action="#">
                        <div class="select_option clearfix">
                            <select>
                                <option value="">Select Your Option</option>
                                <option value="1">Inside City</option>
                                <option value="2">Outside City</option>
                            </select>
                        </div>
                        <br>
                        <button type="submit" class="btn btn_primary rounded-pill">Update Total</button>
                    </form>
                </div>
            </div> --}}

            <div class="col col-lg-12">
                <div class="cart_total_table">
                    <h3 class="wrap_title">Cart Totals</h3>
                    <ul class="ul_li_block">
                        <li>
                            <span>Cart Subtotal</span>
                            <span class="total_price">${{ $total }}</span>
                        </li>
                        <li>
                            <span>Discount</span>
                            <span>
                                @if ($type == 1)
                                {{ $discount }}
                                @else
                                {{ $total * $discount / 100 }}
                                @endif
                            </span>
                        </li>
                        <li>
                            <span>Order Total</span>
                            <span>{{ $sub_total }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- cart_section - end
================================================== -->
@endsection
