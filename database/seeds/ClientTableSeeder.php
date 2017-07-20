<?php

use Illuminate\Database\Seeder;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clientInfos = factory(App\Model\ClientInfo::class)->times(10)->make();

        \App\Model\ClientInfo::insert($clientInfos->toArray());
    }
}
