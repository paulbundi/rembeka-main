<?php

namespace App\Channels;

use AfricasTalking\SDK\AfricasTalking;
use Illuminate\Notifications\Notification;

class SmsChannel
{
    /**
     * Handle sms notifications.
     *
     * @param [type]       $notifiable
     * @param Notification $notification
     *
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSms($notifiable);

        $aft = new AfricasTalking(config('services.aft.username'), config('services.aft.key'));
        $sms = $aft->sms();

        $response = $sms->send([
            'to'      => $message->to,
            'message' => $message->content,
            'from'    => 'Rembeka',
        ]);
    }


    /**
     * Send SMS Notification
     *
     * @param [type] $recipient
     * @param [type] $message
     * @return void
     */
    public function notify($recipient, $message)
    {

        $aft = new AfricasTalking(config('services.aft.username'), config('services.aft.key'));
        $sms = $aft->sms();

        $response = $sms->send([
            'to'      => $recipient,
            'message' => $message,
            'from'    => 'Rembeka',
        ]);
    }
}
