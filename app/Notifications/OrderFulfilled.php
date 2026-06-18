<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderFulfilled extends Notification
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Order Fulfilled - #' . $this->order->order_no)
            ->markdown('mail.notifications.order-fulfilled', ['order' => $this->order]);
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'order_no' => $this->order->order_no,
        ];
    }
}