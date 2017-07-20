<?php

use App\Priority;
use Illuminate\Database\Seeder;

class PriorityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createPriority = new Priority();
        $createPriority->name = '紧急';
        $createPriority->save();

        $createPriority = new Priority();
        $createPriority->name = '普通';
        $createPriority->save();

        $createPriority = new Priority();
        $createPriority->name = '低';
        $createPriority->save();
    }
}
