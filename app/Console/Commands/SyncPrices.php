<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\ProviderPricing;
use Illuminate\Console\Command;

class SyncPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset provider prices with product prices';

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
        Product::chunk(10, function ($products) {
            $products->each(function ($product) {
                $this->info('-------product ----'.$product->id);

                ProviderPricing::where('product_id', $product->id)
                -> update([
                    'service_pricing' =>  $product->product_price,
                    'provider_cost' => $product->cost_of_labour,
                    'amount' => $product->final_price,
                    'cost_of_labour' => $product->cost_of_labour,
                    'commission' => $product->commission,

                ]);
            });
        });

        $this->info('done');

        return 0;
    }
}
