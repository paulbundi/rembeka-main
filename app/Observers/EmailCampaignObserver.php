<?php

namespace App\Observers;

use App\Jobs\SendEmailCampaign;
use App\Models\EmailCampaign;

class EmailCampaignObserver
{
    /**
     * Listen to sms send.
     *
     * @param SendEmailCampaign $campaign
     *
     * @return void
     */
    public function created(EmailCampaign $campaign)
    {
        dispatch(new SendEmailCampaign($campaign));
    }
}
