<?php

namespace App\Console\Commands;

use App\Models\Group;
use Illuminate\Console\Command;

class CreateSMSGroup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:groups';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically Generate System Groups';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        Group::updateOrCreate(
            [
                'filter_criteria' => 'all_clients'
            ],
            [
                'name' => 'All Clients',
                'description' => 'Notify all platform users Except Corporate Accounts',
                'user_id' => 1,
                'type' => Group::TYPE_AUTOMATIC,
            ],
        );

        Group::updateOrCreate(
            [
                'filter_criteria' => 'return_clients'
            ],
            [
                'name' => 'All Return Customers',
                'description' => 'Return Customer except VIPs',
                'user_id' => 1,
                'type' => Group::TYPE_AUTOMATIC,
            ],
        );
        Group::updateOrCreate(
            [
                'filter_criteria' => 'vip_clients'
            ],
            [
                'name' => 'VIP Customers',
                'description' => 'Customers With return times > 5',
                'user_id' => 1,
                'type' => Group::TYPE_AUTOMATIC,
            ],
        );

    }
}
