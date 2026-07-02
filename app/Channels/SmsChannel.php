<?php

namespace App\Channels;

use AfricasTalking\SDK\AfricasTalking;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class SmsChannel
{
    protected function isConfigured(): bool
    {
        return !empty(config('services.aft.username')) && !empty(config('services.aft.key'));
    }

    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSms($notifiable);

        if (!$this->isConfigured()) {
            Log::error('Africa\'s Talking credentials are missing. Set AFT_USERNAME and AFT_KEY in .env');
            return;
        }

        $aft = new AfricasTalking(config('services.aft.username'), config('services.aft.key'));
        $sms = $aft->sms();

        try {
            $response = $sms->send([
                'to'      => $message->to,
                'message' => $message->content,
                'from'    => 'Rembeka',
            ]);
        } catch (\Exception $e) {
            Log::error('SMS sending failed: ' . $e->getMessage());
        }
    }

    public function notify($recipient, $message)
    {
        if (!$this->isConfigured()) {
            Log::error('Africa\'s Talking credentials are missing. Set AFT_USERNAME and AFT_KEY in .env');
            return;
        }

        $aft = new AfricasTalking(config('services.aft.username'), config('services.aft.key'));
        $sms = $aft->sms();

        try {
            $response = $sms->send([
                'to'      => $recipient,
                'message' => $message,
                'from'    => 'Rembeka',
            ]);
        } catch (\Exception $e) {
            Log::error('SMS sending failed: ' . $e->getMessage());
        }
    }
}
