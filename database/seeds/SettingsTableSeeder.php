<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('settings')->insert([
            0 => [
                'id'         => 1,
                'site_name'  => '客服系统',
                'site_url'   => 'http://ticketx.com',
                'email_to'   => 'admin@ticketx.com',
                'email_from' => 'admin@ticketx.com',
                'created_at' => '2016-08-29 13:42:19',
                'updated_at' => '2016-08-29 13:42:19',
            ],
     ]);
    }
}
