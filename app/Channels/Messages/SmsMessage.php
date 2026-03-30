<?php

namespace App\Channels\Messages;

class SmsMessage
{
    public $content;

    public $to;

    public function content($content)
    {
        $this->content = $content;

        return $this;
    }

    public function to($to)
    {
        $this->to = $to;

        return $this;
    }
}
