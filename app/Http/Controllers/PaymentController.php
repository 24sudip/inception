<?php

namespace App\Http\Controllers;
use App\Models\Ebook;
use App\Models\Ebookenroll;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Course;
use App\Models\Enroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderInvoiceMail;
use Illuminate\Support\Facades\URL;

class PaymentController extends Controller
{
    public function surjo(){
        return view('payment_form');
    }

    public function successpage(){
        return view('success');
    }

    public function cancelpage(){
        return view('cancel');
    }

    public function payment(Request $request)
    {
    try {
        $merchant_name = config('surjopay.merchant_name');
        $merchant_password = config('surjopay.merchant_password');

        // Use data from the form (amount, customer_name, etc.)
        $amount = $request->input('amount', 100); // Default to 100 if not provided
        $customer_name = $request->input('customer_name', 'Nazmul');
        $customer_email = $request->input('customer_email', 'test@gmail.com');

        // $url = 'https://sandbox.shurjopayment.com/api/get_token';
        //For Live Use
        $url = 'https://engine.shurjopayment.com/api/get_token';
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                'username' => $merchant_name,
                'password' => $merchant_password,
                'type' => 'json'
            ]),
            CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $responseObject = json_decode($response, true);

        if (isset($responseObject['token']) && $responseObject['token'] != null) {
            $res = $this->createPayment($responseObject, $request);

            if (isset($res['checkout_url']) && $res['checkout_url'] != null) {
                return redirect()->away($res['checkout_url']);
                // return response()->json(['checkout_url' => $res['checkout_url']]);
            } else {
                return redirect()->route('home')->with('error', 'Payment Generation Failed');
            }
        } else {
            return redirect()->route('home')->with('error', 'Token Generation Failed');
        }
    } catch (\Exception $exception) {
        return $exception->getMessage();
    }
}

    public function payments(Request $request)
    {
        try {
            $merchant_name = config('surjopay.merchant_name');
            $merchant_password = config('surjopay.merchant_password');
            // $url = 'https://sandbox.shurjopayment.com/api/get_token';
            $url = 'https://engine.shurjopayment.com/api/get_token';
            //For Live Use 'https://engine.shurjopayment.com/api/get_token';

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'{
                "username": "'.$merchant_name.'",
                "password": "'.$merchant_password.'",
                "type": "json"
            }',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            $responseObject = json_decode($response, true);

            if (isset($responseObject['token']) && $responseObject['token'] != null) {
                $res = $this->createPayment($responseObject, $request);

                if (isset($res['checkout_url']) && $res['checkout_url'] != null) {
                    // return redirect()->away($res['checkout_url']);

                    return response()->json(['checkout_url' => $res['checkout_url']]);
                    //For Inertia Js, Use this to avoid whole tab opening as modal
                    //  return inertia()->location($res['checkout_url']);
                }else{
                    return redirect()->route('cancel')->with('error','Payment Generation Failed');
                }
            }else{
                return redirect()->route('cancel')->with('error','Token Generation Failed');
            }
        }catch (\Exception $exception){
            return $exception->getMessage();
        }

    }

    protected function createPayment($response, Request $request)
    {
        $subtotal = $request->course_price;
        $coupon_code = $request->coupon_code;
        $discount =  $request->discount_amount ;
        $course_id = $request->course_id ?? null;
        $ebook_id = $request->ebook_id ?? null;

        $note  = $request->note;

        // $order              = new Order();
        // $order->student_id  =  $student_id;
        // $order->total       = $total;
        // $order->subtotal    = $subtotal;
        // $order->discount    = $discount;
        // $order->coupon_code = $coupon_code;
        // $order->note        = $request->note ?? null;
        // $order->payment_method        = "surjoPay" ;
        // $res                = $order->save();

        $total_amount = $request->total_amount;


        $user_name = Auth::guard('student')->user()->name;
        $user_email = Auth::guard('student')->user()->email;
        $user_phone = Auth::guard('student')->user()->phone;

        session()->put('total_amount', $total_amount);
        session()->put('coupon_code', $coupon_code);
        session()->put('subtotal', $subtotal);
        session()->put('discount', $discount);
        session()->put('course_id', $course_id);
        session()->put('course_id', $course_id);
        session()->put('ebook_id', $ebook_id);
        session()->put('note', $note);

        try {
            //  $url = 'https://sandbox.shurjopayment.com/api/secret-pay';
            $url = 'https://engine.shurjopayment.com/api/secret-pay';
            //For Live Use 'https://engine.shurjopayment.com/api/secret-pay';

            $token      = $response['token'];
            $store_id   = $response['store_id'];
            $authorizationToken = "Bearer $token";
            $order_id = rand(000000000000,999999999999);

            session()->put('token', $token);

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'{
                "prefix": "sp",
                "token": "'.$token.'",
                "return_url": "'.route('success').'",
                "cancel_url": "'.route('cancel').'",
                "store_id": "'.$store_id.'",
                "amount": "'.$total_amount.'",
                "order_id": "'.$order_id.'",
                "currency": "BDT",
                "customer_name": "'.$user_name.'",
                "customer_address": "Jhenaidah, Khulna, Bangladesh",
                "customer_phone": "'.$user_phone.'",
                "customer_city": "Jhenaidah",
                "customer_post_code": "7200",
                "client_ip": "102.101.1.1",
                "discount_amount": "",
                "disc_percent": "",
                "customer_email": "test@gmail.com",
                "customer_state": "Bangladesh",
                "customer_postcode": "7200",
                "customer_country": "Bangladesh",
                "shipping_address": "Jhenaidah, Khulna, Bangladesh",
                "shipping_city": "Jhenaidah",
                "shipping_country": "Bangladesh",
                "received_person_name": "Nazmul",
                "shipping_phone_number": "01700000000",
                "value1": "test value1",
                "value2": "",
                "value3": "",
                "value4": "",
                "type": "json"
            }',
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json",
                    "Authorization: $authorizationToken",
                ),
            ));

            $res = curl_exec($curl);

            curl_close($curl);

            $resObject = json_decode($res, true);

            return $resObject;

        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function success(Request $request)
    {
        try {
            if (isset($request['order_id']) && $request['order_id'] != null) {
                // For sandbox
                //  $url = 'https://sandbox.shurjopayment.com/api/verification';
               // For Live Use
                $url = 'https://engine.shurjopayment.com/api/verification';


                $token = session()->get('token');
                $order_id      = $request['order_id'];
                $authorizationToken = "Bearer $token";


                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
                        "order_id": "'.$order_id.'",
                        "type": "json"
                    }',
                    CURLOPT_HTTPHEADER => array(
                        "Content-Type: application/json",
                        "Authorization: $authorizationToken",
                    ),
                ));

                $res = curl_exec($curl);
                //  dd($res);
                curl_close($curl);

                $resObject = json_decode($res, true);
                // dd( $resObject);
                // $trxId = $resObject[0]['bank_trx_id'];

                // dd($trxId );
                //Store payment transaction and order details
                session()->forget('token');
                $stu_id = Auth::guard('student')->id();
                //  dd($stu_id);
                $student_id =  $stu_id;
                $total_amount = session()->get('total_amount');

                //  session()->put('total_amount', $total_amount);
                //  session()->put('subtotal', $subtotal);
                //  session()->put('discount', $discount_amount);
                //  session()->put('course_id', $course_id);
                //  session()->put('course_id', $course_id);
                //  session()->put('note', $note);

        $subtotal = session()->get('subtotal');
        $coupon_code = session()->get('coupon_code');
        $discount =   session()->get('discount');
        $note =   session()->get('note');
        $course_id = session()->get('course_id');
        $ebook_id= session()->get('ebook_id');

        // $ebook_id = session()->get('course_id');
        // dd($course_id);

        $order              = new Order();
        $order->student_id  =  $student_id;
        $order->total       = $total_amount;
        $order->subtotal    = $subtotal;
        $order->discount    = $discount;
        $order->coupon_code = $coupon_code;
        $order->note        = $note ?? null;
        $order->payment_method        = "surjoPay" ;

        $order->trx_id =  $resObject[0]['bank_trx_id'];
        $order->invoice_no =  $resObject[0]['invoice_no'];
        $order->status =  $resObject[0]['sp_message'];
        $res                = $order->save();


        // dd($res);
        // <-- here is the order id
        //   dd($ebook_id);

        if ($res) {
            $orderId = $order->id;

                // $orderdetails            = new OrderDetails();
                // $orderdetails->order_id  = $order->id;
                // $orderdetails->course_id =  $course_id ?? null;
                // $orderdetails->ebook_id =  $ebook_id ?? null;
                // $orderdetails->price     = $total_amount;
                // $res                     = $orderdetails->save();

                if( $course_id){
                    // return $course_id;

                    // $enroll             = new Enroll();
                    // $enroll->student_id = Auth::guard('student')->user()->id;
                    // $enroll->course_id  =  $course_id;
                    // $enroll->save();

                    // $course   = Course::find($enroll->course_id);
                    // $instructor_commision = ($course->instructor_commision / 100) * $orderdetails->price;
                    // $course->enrolled += 1;
                    // $course->revenue += $orderdetails->price - $instructor_commision;
                    // $course->commision_amount += $instructor_commision;
                    // $course->commision_due += $instructor_commision;
                    // $course->commision_paystatus = null;
                    // $course->save();
                }


                else{
                    // return  $ebook_id;

                    // $enroll             = new Ebookenroll ();
                    // $enroll->student_id = Auth::guard('student')->user()->id;
                    // $enroll->ebook_id  = $ebook_id;
                    // $enroll->save();
                    // $ebook  = Ebook::find($enroll->ebook_id);
                    // $ebook->enrolled += 1;
                    // $ebook->save();
                }
            }
            Session::forget('cart');
            Session::forget('discount');
            Session::forget('coupon_code');
            $signedLoginUrl = URL::signedRoute(
                'student.autologin',

                ['student' =>  Auth::guard('student')->user()->id]
            );

                // Mail::to(Auth::guard('student')->user()->email)->send(new OrderInvoiceMail($order, $orderdetails,$signedLoginUrl));
                return redirect()->route('success.page')->with('success','Order placed successfully')->with('order_id', $orderId);
            }
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    public function cancel(Request $request)
    {
        return redirect()->route('cancel.page')->with('error','Order Cancelled!');
    }
}
