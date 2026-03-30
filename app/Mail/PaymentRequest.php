<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;

class PaymentRequest extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var Order
     */
    protected $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $pdf = PDF::loadView('mail.pdf.order-payment', ['order' => $this->order]);

        return $this->markdown('mail.payment-request', [
            'order' => $this->order,
        ])->attachData($pdf->output(), 'payment.pdf', ['mime' => 'application/pdf']);
    }
}
