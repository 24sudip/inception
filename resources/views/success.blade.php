@extends('frontend.layout.theme')

@section('content')

<section id="quicktech-exam-details" class="pt-5">
    <div class="container pt-5">
             <div class="row gapp mt-5 mb-5">
        <h2>Payment Successful!</h2>


       {{-- @if(session('order_id'))
        <p>Your Order ID is: <strong>{{ session('order_id') }}</strong></p>
      @endif --}}

        <p>Your payment has been successfully processed.</p>
         </div>
     </div>
</section>

@endsection
