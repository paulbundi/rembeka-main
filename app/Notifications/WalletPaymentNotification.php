<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use PDF;

class WalletPaymentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order, $amount)
    {
        $this->order =  $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        $pdf = PDF::loadView('mail.pdf.order-payment', ['order' => $this->order]);

        return (new MailMessage)
                    ->subject('Order Payment')
                    ->line('Payment has been made from your wallet for Order NO. '. $this->order->order_no)
                    ->line('Please check attached invoice for more details.')
                    ->line('Thank you, From Rembeka Online Limited')
                    ->attachData($pdf->output(), 'invoice.pdf', ['mime' => 'application/pdf']);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
