<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class CalculatePricing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recalculate:order {order_no}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rec-calculate the payable amount on an order.';

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
        $orderNo = $this->argument('order_no');
        $order = Order::where('order_no', $orderNo)->first();

        if ($order) {
            updateOrderPricing($order->id);
        }

        return 0;
    }
}
