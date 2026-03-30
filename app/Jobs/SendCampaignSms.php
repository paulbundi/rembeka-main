<?php

namespace App\Jobs;

use App\Models\Group;
use App\Models\SmsCampaign;
use App\Models\User;
use App\Notifications\SmsNotification;
use App\Pivots\GroupUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendCampaignSms implements ShouldQueue
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
        if ($this->campaign->type == SmsCampaign::TYPE_GROUP) {

            $this->campaign->load('group');

            if ($this->campaign->group->type == Group::TYPE_AUTOMATIC) {
                $this->handleAutomaticGroups();
            } else {
                GroupUser::where('group_id', $this->campaign->group_id)
                    ->with(['user'])
                    ->chunk(4, function ($groupUsers) {
                        $groupUsers->each(function ($groupUser) {
                            if ($groupUser->user) {
                                $groupUser->user->notify(new SmsNotification($this->campaign->message, false));
                            }
                        });
                    });
            }
            
            $this->campaign->sent = 1;
            $this->campaign->save();

            return;
        }

        $user = User::where('id', $this->campaign->user_id)->first();
        $user->notify(new SmsNotification($this->campaign->message, false));

        $this->campaign->sent = 1;
        $this->campaign->save();
    }



    public function handleAutomaticGroups()
    {
        if ($this->campaign->group->filter_criteria == 'all_clients') {
            User::chunk(10, function ($users) {
                $users->each(function ($user) {
                    $user->notify(new SmsNotification($this->campaign->message, false));
                });
            });
        }

        if ($this->campaign->group->filter_criteria == 'return_clients') {
            User::whereBetween('return_times', [1,5])->chunk(10, function ($users) {
                $users->each(function ($user) {
                    $user->notify(new SmsNotification($this->campaign->message, false));
                });
            });
        }

        if ($this->campaign->group->filter_criteria == 'vip_clients') {
            User::where('return_times', '>', 5)->chunk(10, function ($users) {
                $users->each(function ($user) {
                    $user->notify(new SmsNotification($this->campaign->message, false));
                });
            });
        }
    }
}
