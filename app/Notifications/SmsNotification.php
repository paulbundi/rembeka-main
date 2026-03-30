<?php

namespace App\Notifications;

use App\Channels\Messages\SmsMessage;
use App\Channels\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SmsNotification extends Notification implements ShouldQueue
{
    use Queueable;
    /**
     * @var string
     */
    public $message;

    /**
     * @var bool
     */
    public $useMail;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message, $useMail = false)
    {
        $this->message = $message;
        $this->useMail = $useMail;
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
        $channel = [SmsChannel::class];

        if ($notifiable->sms_blocked == 1 && $this->useMail) {
            $channel = ['mail'];
        }

        if ($notifiable->sms_blocked !=1 && $this->useMail) {
            $channel = [ SmsChannel::class, 'mail'];
        }

        if ($notifiable->sms_blocked == 1 && !$this->useMail) {
            $channel = [];
        }
        return $channel;
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
        return (new MailMessage)
                    ->greeting('Hi '.$notifiable->first_name)
                    ->line($this->message);
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toSms($notifiable)
    {
        $message = $this->message;

        if (preg_match('/:first_name/', $message)) {
            $message =str_replace(':first_name', $notifiable->first_name, $message);
        }

        $phone = str_replace(' ', '', '+254'.substr($notifiable->phone, -9));
        
        return (new SmsMessage)
            ->to($phone)
            ->content($message);
    }
}
