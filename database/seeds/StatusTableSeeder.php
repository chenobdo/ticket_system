<?php

use App\Status;
use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createStatus = new Status();
        $createStatus->name = '新建';
        $createStatus->save();

        $createStatus = new Status();
        $createStatus->name = '进行中';
        $createStatus->save();

        $createStatus = new Status();
        $createStatus->name = '关闭';
        $createStatus->save();

        $createStatus = new Status();
        $createStatus->name = '重开';
        $createStatus->save();
    }
}
