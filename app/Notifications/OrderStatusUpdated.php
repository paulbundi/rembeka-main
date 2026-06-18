<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusUpdated extends Notification
{
    use Queueable;

    protected $order;
    protected $statusMessage;

    public function __construct(Order $order, string $statusMessage)
    {
        $this->order = $order;
        $this->statusMessage = $statusMessage;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = url('/account/orders/' . $this->order->id);

        return (new MailMessage)
            ->subject('Order Update - #' . $this->order->order_no)
            ->greeting('Hello ' . $notifiable->first_name . ',')
            ->line($this->statusMessage)
            ->line('**Order Number:** ' . $this->order->order_no)
            ->line('**Order Amount:** KES ' . number_format($this->order->amount, 2))
            ->action('View Order Details', $url)
            ->line('Thank you for choosing Rembeka!');
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'order_no' => $this->order->order_no,
            'message' => $this->statusMessage,
        ];
    }
}