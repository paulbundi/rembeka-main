<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        // Model::preventLazyLoading(! $this->app->isProduction());

        // DB::listen(function(QueryExecuted $event) {
        //     Log::info(
        //         'SQL Query',
        //         [
        //             $event->sql,
        //             $event->bindings,
        //             $event->time,
        //         ]
        //     );
        // });
    }
}
