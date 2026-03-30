<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\User;
use Illuminate\Console\Command;

class ReturnRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'return:rate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get the number of times a customer has booked with us';

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
        User::chunk(4, function ($users) {
            $users->each(function ($user) {
                $orders = Order::where('user_id', $user->id)->count();
                $user->return_times = $orders;
                $user->save();
            });
        });

        return 0;
    }
}
