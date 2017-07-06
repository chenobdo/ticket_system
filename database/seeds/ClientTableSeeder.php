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
        $clients = factory(App\Model\Client::class)->times(10)->make();

        \App\Model\Client::insert($clients->toArray());
    }
}
