<?php

namespace App\Jobs;

use App\Mail\EmailCampaignMail;
use App\Models\EmailCampaign;
use App\Models\User;
use App\Pivots\GroupUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailCampaign implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $campaign;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($campaign)
    {
        $this->campaign = $campaign;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->campaign->type == EmailCampaign::TYPE_GROUP) {
            GroupUser::where('group_id', $this->campaign->group_id)
                ->with(['user'])
                ->chunk(10, function ($groupUsers) {
                    $groupUsers->each(function ($groupUser) {
                        Mail::to($groupUser->user)->send(new EmailCampaignMail($this->campaign));
                    });
                });

            $this->campaign->sent = 1;
            $this->campaign->save();

            return;
        }

        $user = User::where('id', $this->campaign->user_id)->first();
        Mail::to($user)->send(new EmailCampaignMail($this->campaign));

        $this->campaign->sent = 1;
        $this->campaign->save();
    }
}
