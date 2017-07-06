<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Model\Client::class, function (Faker\Generator $faker) {
    $start = 1420041600; //2015-01-01 00:00:00
    $end = 1499356800; //2017-07-07 00:00:00
    return [
        'fuyou_account'          => str_random(30),
        'pay_type'               => mt_rand(1, 5),
        'deduct_time'            => date('H:i:s', mt_rand($start, $end)),
        'posno'                  => str_random(10),
        'fee'                    => mt_rand(0, 9999) + mt_rand(0, 9999) / mt_getrandmax(),
        'import_bank'            => str_random('64'),
        'import_account'         => str_random('32'),
        'import_name'            => str_random('16'),
        'export_bank'            => str_random('64'),
        'export_account'         => str_random('32'),
        'export_name'            => str_random('16'),
        'area_id'                => mt_rand(1, 999),
        'area_name'              => str_random('16'),
        'city_id'                => mt_rand(1, 999),
        'city_name'              => str_random('16'),
        'section'                => str_random('32'),
        'director'               => str_random('16'),
        'area_manager'           => str_random('16'),
        'city_manager'           => str_random('16'),
        'store_manager'          => str_random('16'),
        'team_manager'           => str_random('16'),
        'account_manager'        => str_random('16'),
        'account_manager_cardid' => str_random('18'),
        'status'                 => mt_rand(1, 999),
        'deleted_at'             => mt_rand(1000000000, 9999999999),
        'created_at'             => mt_rand(1000000000, 9999999999),
        'updated_at'             => mt_rand(1000000000, 9999999999)
    ];
});
