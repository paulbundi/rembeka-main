<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderConfirmation extends Notification
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
        $url = url('/account/orders/' . $this->order->id);

        return (new MailMessage)
            ->subject('Order Confirmation - #' . $this->order->order_no)
            ->greeting('Hello ' . $notifiable->first_name . ',')
            ->line('Thank you for your order! We have received your request and are processing it.')
            ->line('**Order Number:** ' . $this->order->order_no)
            ->line('**Order Total:** KES ' . number_format($this->order->amount, 2))
            ->line('**Amount Paid:** KES ' . number_format($this->order->paid, 2))
            ->line('**Balance:** KES ' . number_format($this->order->balance, 2))
            ->action('View Order Details', $url)
            ->line('You will receive updates as your order progresses.');
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'order_no' => $this->order->order_no,
        ];
    }
}