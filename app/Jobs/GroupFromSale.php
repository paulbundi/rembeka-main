<?php

namespace App\Jobs;

use App\Models\Group;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GroupFromSale implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     *
     * @var Group
     */
    public $group;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Group $group)
    {
        $this->group = $group;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        OrderItem::where('product_id', $this->group->product_id)
            ->with(['order.customer'])
            ->chunk(10, function ($orderItems) {
                $orderItems->each(function ($item) {
                    if ($item->order && $item->order->customer && $item->order->customer->account_type != User::TYPE_CORPORATE) {
                        $this->group->users()->syncWithoutDetaching($item->order->user_id);
                    }
                });
            });
    }
}
