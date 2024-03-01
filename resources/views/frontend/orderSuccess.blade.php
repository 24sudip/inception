@extends('frontend.frontendMaster')

@section('content')
<!-- breadcrumb_section - start
================================================== -->
<div class="breadcrumb_section">
    <div class="container">
        <ul class="breadcrumb_nav ul_li">
            <li><a href="{{ route('customer_home') }}">Home</a></li>
            <li>Order Confirm</li>
        </ul>
    </div>
</div>
<!-- breadcrumb_section - end
================================================== -->

<!-- start error-404-section -->
<section class="error-404-section section_space">
    <div class="container">
        <div class="error-404-area">
            <h2 style="font-size: 72px" class="text-center">Order Successful</h2>
            <div class="error-message">
                <h3 class="mt-4">Thank You For Your Order</h3>
                <p>You are welcome to visit again</p>
                <a href="{{ route('customer_home') }}" class="btn btn_primary">Back to home</a>
            </div>
        </div>
    </div>
</section>
<!-- end error-404-section -->
@endsection
