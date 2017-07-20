<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\User;

class PackageContacts extends Command
{
    use DispatchesJobs;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update_month_bill';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update current month all contacts bills';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->dispatch(new UpdateBill(null, Zip::TYPE_AUTO, User::first()));
    }
}
