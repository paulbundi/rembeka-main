<?php

namespace App\Console\Commands;

use App\Models\Provider;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Console\Command;

class RatingCalculator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:rating';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'User and provider rating calculator';

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
        User::active()->chunk(10, function ($users) {
            $users->each(function ($user) {
                $rating = Rating::where('rateable_id', $user->id)
                    ->where('rateable_type', 'App\Models\User')
                    ->avg('rating');

                if ($rating && $user->rating != $rating) {
                    $user->rating = $rating;
                    $user->save();
                }
            });
        });

        Provider::active()->chunk(10, function ($providers) {
            $providers->each(function ($provider) {
                $rating = Rating::where('rateable_id', $provider->id)
                    ->where('rateable_type', 'App\Models\Provider')
                    ->avg('rating');

                if ($rating && $provider->rating != $rating) {
                    $provider->rating = $rating;
                    $provider->save();
                }
            });
        });

        return 0;
    }
}
