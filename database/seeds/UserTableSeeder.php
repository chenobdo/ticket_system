<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->delete();

        \DB::table('users')->insert([
            0 => [
                'id'             => 1,
                'fullname'       => 'Admin',
                'username'       => 'admin',
                'email'          => 'admin@ticketx.com',
                'password'       => bcrypt('12345678'),
                'gender'         => 'M',
                'location'       => 'Oslo,Norway',
                'website'        => 'http://ticketx.com',
                'remember_token' => null,
                'created_at'     => '2016-08-29 13:42:19',
                'updated_at'     => '2016-08-29 13:42:19',
            ]
        ]);
    }
}
