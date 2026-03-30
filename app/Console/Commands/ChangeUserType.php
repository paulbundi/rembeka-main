<?php

namespace App\Console\Commands;

use App\Models\Provider;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Console\Command;

class ChangeUserType extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change-user:type';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change from user to supplier';

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

        Supplier::with(['user'])->chunk(6, function ($suppliers) {
            $suppliers->each(function ($supplier) {
                if ($supplier->user_id) {
                    $user = User::find($supplier->user_id);
                    if ($user->account_type == User::TYPE_USER && $user->organization_id == null) {
                        $user->account_type = User::TYPE_SUPPLIER;
                        // $this->info('-----------'.$user->first_name.''.$user->last_name.'----------------');
                        $user->save();
                    }
                }
            });
        });
        return 0;
    }
}
