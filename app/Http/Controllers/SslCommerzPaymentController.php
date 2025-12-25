<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use Carbon\Carbon;
use App\Models\Sslorder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SslCommerzPaymentController extends Controller
{
    /**
     * STEP 1: INITIATE PAYMENT
     */
    public function index(Request $request)
    {
        $student = Auth::guard('student')->user();

        if (!$student) {
            return redirect()->route('student.login');
        }

        $tran_id = uniqid('SSL_');

        $post_data = [];
        $post_data['total_amount'] = $request->total_amount;
        $post_data['currency']     = "BDT";
        $post_data['tran_id']      = $tran_id;

        // CUSTOMER INFO
        $post_data['cus_name']     = $student->name;
        $post_data['cus_email']    = $student->email;
        $post_data['cus_phone']    = $student->phone ?? '01700000000';
        $post_data['cus_add1']     = 'Bangladesh';
        $post_data['cus_country'] = 'Bangladesh';

        // SHIPPING INFO (MANDATORY)
        $post_data['ship_name']    = "Online Course";
        $post_data['ship_add1']    = "Dhaka";
        $post_data['ship_city']    = "Dhaka";
        $post_data['ship_country']= "Bangladesh";
        $post_data['shipping_method'] = "NO";

        // PRODUCT INFO
        $post_data['product_name']     = "Course / Ebook";
        $post_data['product_category'] = "Education";
        $post_data['product_profile']  = "non-physical-goods";

        // 🔐 PASS CUSTOM DATA (IMPORTANT)
        $post_data['value_a'] = $student->id;
        $post_data['value_b'] = $request->course_id;
        $post_data['value_c'] = $request->ebook_id;
        $post_data['value_d'] = json_encode([
            'subtotal'    => $request->course_price,
            'discount'    => $request->discount_amount,
            'coupon_code' => $request->coupon_code,
            'note'        => $request->note,
        ]);

        // SAVE PENDING ORDER
        Order::create([
            'student_id'     => $student->id,
            'transaction_id' => $tran_id,
            'amount'         => $request->total_amount,
            'currency'       => 'BDT',
            'status'         => 'Pending',
        ]);

        $sslc = new SslCommerzNotification();
        return $sslc->makePayment($post_data, 'hosted');
    }

    /**
     * STEP 2: SUCCESS CALLBACK
     */
    public function sslsuccess(Request $request)
    {
        $tran_id  = $request->tran_id;
        $amount   = $request->amount;
        $currency = $request->currency;

        $sslc = new SslCommerzNotification();

        $order = Order::where('transaction_id', $tran_id)->first();

        if (!$order || $order->status !== 'Pending') {
            return redirect()->route('ssl.successblade');
        }

        // ✅ VALIDATE PAYMENT
        $is_valid = $sslc->orderValidate(
            $request->all(),
            $tran_id,
            $amount,
            $currency
        );

        if (!$is_valid) {
            $order->update(['status' => 'Failed']);
            return redirect()->route('ssl.cancelblade')
                ->with('error', 'Payment validation failed');
        }

        // 🔐 TRUST ONLY SSL DATA
        $student_id = $request->value_a;
        $course_id  = $request->value_b;
        $ebook_id   = $request->value_c;
        $extra      = json_decode($request->value_d, true);

        // UPDATE ORDER
        $order->update([
            'subtotal'       => $extra['subtotal'] ?? null,
            'discount'       => $extra['discount'] ?? null,
            'coupon_code'    => $extra['coupon_code'] ?? null,
            'note'           => $extra['note'] ?? null,
            'payment_method' => 'SSLCommerz',
            'trx_id'         => $request->bank_trx_id,
            'invoice_no'     => $request->invoice_no,
            'status'         => 'Paid',
        ]);

        // OrderDetails::create([
        //     'order_id' => $order->id,
        //     'course_id'=> $course_id,
        //     'ebook_id' => $ebook_id,
        //     'price'    => $amount,
        // ]);

        // ENROLL COURSE
        if ($course_id) {
            // Enroll::firstOrCreate([
            //     'student_id' => $student_id,
            //     'course_id'  => $course_id,
            // ]);
        }

        // 🔑 AUTO LOGIN STUDENT (FIX LOGOUT ISSUE)
        // $student = Student::find($student_id);
        // if ($student) {
        //     Auth::guard('student')->login($student);
        // }

        return redirect()
            ->route('ssl.successblade')
            ->with('success', 'Payment completed successfully!');
    }

    /**
     * PAYMENT FAIL
     */
    public function fail(Request $request)
    {
        Order::where('transaction_id', $request->tran_id)
            ->update(['status' => 'Failed']);

        return redirect()->route('ssl.cancelblade')
            ->with('error', 'Payment failed');
    }

    /**
     * PAYMENT CANCEL
     */
    public function cancel(Request $request)
    {
        Order::where('transaction_id', $request->tran_id)
            ->update(['status' => 'Canceled']);

        return redirect()->route('ssl.cancelblade')
            ->with('error', 'Payment cancelled');
    }

    /**
     * IPN (OPTIONAL BUT RECOMMENDED)
     */
    public function ipn(Request $request)
    {
        // You can repeat success validation here for extra security
    }
    public function exampleEasyCheckout()
    {
        return view('exampleEasycheckout');
    }

    public function exampleHostedCheckout()
    {
        return view('exampleHosted');
    }

    public function index_two(Request $request)
    {
        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "sslorders"
        # In "sslorders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.
        $data = session('data');

        $post_data = array();
        $post_data['total_amount'] = $data['total']+$data['charge']; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        #Before  going to initiate the payment order status need to insert or update as Pending.
        $update_product = DB::table('sslorders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'amount' => $data['total']+$data['charge'],
                'status' => 'Pending',
                'address' => $data['address'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency'],
                'customer_id'=>$data['customer_id'],
                'company'=>$data['company'],
                'country'=>$data['country'],
                'city'=>$data['city'],
                'notes'=>$data['notes'],
                'discount'=>$data['discount'],
                'charge'=>$data['charge'],
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    public function payViaAjax(Request $request)
    {

        # Here you have to receive all the order data to initate the payment.
        # Lets your oder trnsaction informations are saving in a table called "sslorders"
        # In sslorders table order uniq identity is "transaction_id","status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = '10'; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = 'Customer Name';
        $post_data['cus_email'] = 'customer@mail.com';
        $post_data['cus_add1'] = 'Customer Address';
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = "";
        $post_data['cus_state'] = "";
        $post_data['cus_postcode'] = "";
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = '8801XXXXXXXXX';
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";


        #Before  going to initiate the payment order status need to update as Pending.
        $update_product = DB::table('sslorders')
            ->where('transaction_id', $post_data['tran_id'])
            ->updateOrInsert([
                'name' => $post_data['cus_name'],
                'email' => $post_data['cus_email'],
                'phone' => $post_data['cus_phone'],
                'amount' => $post_data['total_amount'],
                'status' => 'Pending',
                'address' => $post_data['cus_add1'],
                'transaction_id' => $post_data['tran_id'],
                'currency' => $post_data['currency']
            ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }

    public function success(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $order_id = uniqid();
        $data = Sslorder::where('transaction_id', $tran_id)->get();
        Order::insert([
            'customer_id'=>$data->first()->customer_id,
            'order_id'=>$order_id,
            'name'=>$data->first()->name,
            'email'=>$data->first()->email,
            'company'=>$data->first()->company,
            'phone'=>$data->first()->phone,
            'country'=>$data->first()->country,
            'city'=>$data->first()->city,
            'address'=>$data->first()->address,
            'notes'=>$data->first()->notes,
            'discount'=>$data->first()->discount,
            'charge'=>$data->first()->charge,
            'total'=>$data->first()->amount,
            'created_at'=>now(),
        ]);
        $carts = Cart::where('customer_id', $data->first()->customer_id)->get();
        foreach ($carts as $cart) {
            OrderProduct::insert([
                'customer_id'=>$cart->customer_id,
                'order_id'=>$order_id,
                'product_id'=>$cart->product_id,
                'color_id'=>$cart->color_id,
                'size_id'=>$cart->size_id,
                'quantity'=>$cart->quantity,
            ]);
        }
        return redirect()->route('order.success');

        //    $searched_keyword = $request->keyword;
        //    Product::where('product_name', 'like', '%' .$searched_keyword. '%')->get();

        // $sslc = new SslCommerzNotification();

        // #Check order status in order tabel against the transaction id or order id.
        // $order_details = DB::table('sslorders')
        //     ->where('transaction_id', $tran_id)
        //     ->select('transaction_id', 'status', 'currency', 'amount')->first();

        // if ($order_details->status == 'Pending') {
        //     $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

        //     if ($validation) {
        //         /*
        //         That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
        //         in order table as Processing or Complete.
        //         Here you can also sent sms or email for successfull transaction to customer
        //         */
        //         $update_product = DB::table('sslorders')
        //             ->where('transaction_id', $tran_id)
        //             ->update(['status' => 'Processing']);

        //         echo "<br >Transaction is successfully Completed";
        //     }
        // } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
        //     /*
        //      That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
        //      */
        //     echo "Transaction is successfully Completed";
        // } else {
        //     #That means something wrong happened. You can redirect customer to your product page.
        //     echo "Invalid Transaction";
        // }


    }

    public function fail_two(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('sslorders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 'Pending') {
            $update_product = DB::table('sslorders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Failed']);
            echo "Transaction is Falied";
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }
    }

    public function cancel_two(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('sslorders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 'Pending') {
            $update_product = DB::table('sslorders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Canceled']);
            echo "Transaction is Cancel";
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }
    }

    public function ipn_two(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('sslorders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = DB::table('sslorders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Processing']);

                    echo "Transaction is successfully Completed";
                }
            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }
}
