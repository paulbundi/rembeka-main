<?php

namespace App\Observers;

use App\Jobs\SendCampaignSms;
use App\Models\SmsCampaign;

class SmsCampaignObserver
{
    /**
     * Listen to sms send.
     *
     * @param SmsCampaign $campaign
     *
     * @return void
     */
    public function created(SmsCampaign $campaign)
    {
        dispatch(new SendCampaignSms($campaign));
    }
}
