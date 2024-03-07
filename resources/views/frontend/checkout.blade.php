@extends('frontend.frontendMaster')

@section('content')
<!-- breadcrumb_section - start
================================================== -->
<div class="breadcrumb_section">
    <div class="container">
        <ul class="breadcrumb_nav ul_li">
            <li><a href="{{ route('customer_home') }}">Home</a></li>
            <li>Check Out</li>
        </ul>
    </div>
</div>
<!-- breadcrumb_section - end
================================================== -->
<!-- checkout-section - start
================================================== -->
<section class="checkout-section section_space">
    <div class="container">
        <div class="row">
            <div class="col col-xs-12">
            <div class="woocommerce bg-light p-3">
                <form name="checkout" method="post" class="checkout woocommerce-checkout" action="{{ route('order.store') }}">
                    @csrf
                    <div class="col2-set" id="customer_details">
                        <div class="coll-1">
                        <div class="woocommerce-billing-fields">
                            <h3>Billing Details</h3>
                            <p class="form-row form-row form-row-first validate-required" id="billing_first_name_field">
                                <label for="billing_first_name" class="">Name<abbr class="required" title="required">*</abbr></label>
                                <input type="text" class="input-text " name="name" id="billing_first_name" placeholder="" autocomplete="given-name" value="" />
                            </p>
                            <p class="form-row form-row form-row-last validate-required validate-email" id="billing_email_field">
                                <label for="billing_email" class="">Email Address <abbr class="required" title="required">*</abbr></label>
                                <input type="email" class="input-text " name="email" id="billing_email" placeholder="" autocomplete="email" value="" />
                            </p>
                            <div class="clear"></div>
                            <p class="form-row form-row form-row-first" id="billing_company_field">
                                <label for="billing_company" class="">Company Name</label>
                                <input type="text" class="input-text " name="company" id="billing_company" placeholder="" autocomplete="organization" value="" />
                            </p>

                            <p class="form-row form-row form-row-last validate-required validate-phone" id="billing_phone_field">
                                <label for="billing_phone" class="">Phone <abbr class="required" title="required">*</abbr></label>
                                <input type="tel" class="input-text " name="phone" id="billing_phone" placeholder="" autocomplete="tel" value="" />
                            </p>
                            <div class="clear"></div>
                            <p class="form-row form-row form-row-first address-field update_totals_on_change validate-required" id="billing_country_field">
                                <label for="billing_country" class="">Country <abbr class="required" title="required">*</abbr></label>
                                <select name="country" id="billing_country" autocomplete="country" class="country_to_state country_select">
                                    <option value="">Select a country&hellip;</option>
                                    <option value="AX" selected='selected'>&#197;land Islands</option>
                                    <option value="AF">Afghanistan</option>
                                    <option value="AL">Albania</option>
                                    <option value="DZ">Algeria</option>
                                    <option value="AS">American Samoa</option>
                                </select>
                            </p>
                            <p class="form-row form-row form-row-last address-field update_totals_on_change validate-required" id="billing_country_field">
                                <label for="billing_country" class="">City <abbr class="required" title="required">*</abbr></label>
                                <select name="city" id="billing_country" autocomplete="country" class="country_to_state country_select">
                                    <option value="">Select a City&hellip;</option>
                                    <option value="AX" selected='selected'>&#197;land Islands</option>
                                    <option value="AF">Washinton</option>
                                    <option value="AL">San francisco</option>
                                    <option value="DZ">London</option>
                                    <option value="AS">Alaska</option>
                                </select>
                            </p>
                            <p class="form-row form-row form-row-wide address-field validate-required" id="billing_address_1_field">
                                <label for="billing_address_1" class="">Address <abbr class="required" title="required">*</abbr></label>
                                <input type="text" class="input-text " name="address" id="billing_address_1" placeholder="Street address" autocomplete="address-line1" value="" />
                            </p>
                        </div>
                        <p class="form-row form-row notes" id="order_comments_field">
                                <label for="order_comments" class="">Order Notes</label>
                                <textarea name="notes" class="input-text " id="order_comments" placeholder="Notes about your order, e.g. special notes for delivery." rows="2" cols="5"></textarea>
                            </p>
                        </div>
                    </div>
                    <h3 id="order_review_heading">Your order</h3>
                    <div id="order_review" class="woocommerce-checkout-review-order">
                        <table class="shop_table woocommerce-checkout-review-order-table">
                            <tr class="cart-subtotal">
                                @php
                                $total = 0;
                                foreach ($carts as $cart) {
                                    if ($cart->relation_to_product->discount_price) {
                                        $product_price = $cart->relation_to_product->discount_price;
                                    } else {
                                        $product_price = $cart->relation_to_product->regular_price;
                                    }
                                    $total += $product_price * $cart->quantity;
                                }
                                @endphp
                                <th>Subtotal</th>
                                <td><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">&#2547;</span>{{ $total }}</span>
                                </td>
                            </tr>
                            <tr class="cart-subtotal">
                                <th>Discount</th>
                                <td><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol">&#2547;</span>{{ $total - session('sub_total') }}</span>
                                </td>
                            </tr>
                            <tr class="shipping">
                                <td data-title="Shipping">
                                    <div class="mb-3">
                                        <input type="radio" name="charge" data-total="{{ session('sub_total') }}" id="one" value="80" class="charge" />
                                        <label for="one" class="form-label">Inside City</label>
                                    </div>
                                    <div class="mb-3">
                                        <input type="radio" name="charge" data-total="{{ session('sub_total') }}" id="two" value="130" class="charge" />
                                        <label for="two" class="form-label">Outside City</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="order-total">
                                <th>Delivery Charge</th>
                                <td><strong>&#2547;<span class="woocommerce-Price-amount amount" id="charge"><span class="woocommerce-Price-currencySymbol"></span>0</span></strong> </td>
                            </tr>
                            <tr class="order-total">
                                <th>Total</th>
                                <td><strong>&#2547;<span class="woocommerce-Price-amount amount" id="grand_total"><span class="woocommerce-Price-currencySymbol"></span>{{ session('sub_total') }}</span></strong> </td>
                            </tr>
                        </table>
                        <div id="payment" class="woocommerce-checkout-payment py-3 mt-5">
                        <ul class="wc_payment_methods payment_methods methods">
                            <li class="wc_payment_method payment_method_cheque mb-2">
                                <input id="payment_method_cheque" type="radio" class="input-radio" name="payment_method" value="1" checked='checked' data-order_button_text="" />
                                <!--grop add span for radio button style-->
                                <span class='grop-woo-radio-style'></span>
                                <!--custom change-->
                                <label for="payment_method_cheque">Cash On Delivery</label>
                            </li>
                            <li class="wc_payment_method payment_method_paypal mb-2">
                                <input id="payment_method_ssl" type="radio" class="input-radio" name="payment_method" value="2" data-order_button_text="Proceed to SSL Commerz" />
                                <!--grop add span for radio button style-->
                                <span class='grop-woo-radio-style'></span>
                                <!--custom change-->
                                <label for="payment_method_ssl">SSL Commerz</label>
                            </li>
                            {{-- <li class="wc_payment_method payment_method_paypal">
                                <input id="payment_method_stripe" type="radio" class="input-radio" name="payment_method" value="3" data-order_button_text="Proceed to SSL Commerz" />
                                <!--grop add span for radio button style-->
                                <span class='grop-woo-radio-style'></span>
                                <!--custom change-->
                                <label for="payment_method_stripe">Stripe Payment</label>
                            </li> --}}
                        </ul>
                        <input type="hidden" name="customer_id" value="{{ Auth::id() }}">
                        <input type="hidden" name="discount" value="{{ $total - session('sub_total')}}">
                        <input type="hidden" name="total" value="{{ session('sub_total')}}">
                        <div class="form-row place-order">
                            <noscript>
                                Since your browser does not support JavaScript, or it is disabled, please ensure you click the <em>Update Totals</em> button before placing your order. You may be charged more than the amount stated above if you fail to do so.
                                <br/>
                                <input type="submit" class="button alt" name="woocommerce_checkout_update_totals" value="Update totals" />
                            </noscript>
                            <input type="submit" class="button alt" id="place_order" value="Place order" data-value="Place order"/>
                        </div>
                        </div>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
</section>
<!-- checkout-section - end
================================================== -->
@endsection
@section('footer_script')

<script>
    $('.charge').click(function () {
        var charge = $(this).val();
        var sub_total = $(this).attr('data-total');
        var grand_total = parseInt(sub_total) + parseInt(charge) ;
        $('#charge').html(charge);
        $('#grand_total').html(grand_total);
    });
</script>
@endsection
