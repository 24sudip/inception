<?php

namespace App\Mail;

// use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $orderdetails;
    public $signedLoginUrl;

    public function __construct($order, $orderdetails, $signedLoginUrl)
    {
        $this->order = $order;
        $this->orderdetails = $orderdetails;
        $this->signedLoginUrl = $signedLoginUrl;
    }

    public function build()
    {
        // Generate PDF from blade view, passing order data
        $pdf = Pdf::loadView('pdf.invoice', [
            'order' => $this->order,
            'orderdetails' => $this->orderdetails,
        ])->setPaper('a4', 'portrait'); // default is portrait

        // Compose email with subject, markdown body, and attach PDF
        return $this->subject('Course Enrollment Confirmation')
        ->markdown('emails.invoice') // your markdown email content
        ->attachData($pdf->output(), 'invoice_' . $this->order->invoice_no . '.pdf', [
            'mime' => 'application/pdf',
        ]);
        //     $pdf = Pdf::loadView('pdf.invoice', [
        //     'order' => $this->order,
        //     'orderdetails' => $this->orderdetails
        // ])->setPaper('a4');

        // return $this->subject('Course Enrollment Confirmation')
        //             ->markdown('emails.invoice')
        //             ->attachData($pdf->output(), 'invoice_'.$this->order->invoice_no.'.pdf', [
        //                 'mime' => 'application/pdf',
        //             ]);
        // return $this->subject('Course Enrollment Confirmation')
        //             ->markdown('emails.invoice');
    }
}
