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

    $gender = ['M', 'F'];

    $int = mt_rand(0, 9999);
    $float = mt_rand(0, 99);
    $if = strval($int) . '.' . strval($float);

    return [
        'contractno'        => str_random(10),
        'is_continue'       => mt_rand(1, 4),
        'client'            => str_random(10),
        'cardid'            => str_random(18),
        'gender'            => $gender[mt_rand(0, 1)],
        'bond_type'         => mt_rand(1, 4),
        'address'           => str_random(20),
        'bond_type'         => mt_rand(100000, 999999),
        'FTC'               => floatval($if),
        'FTA'               => floatval($if),
        'receipt_date'      => date('Y-m-d', mt_rand($start, $end)),
        'is_confirm'        => mt_rand(1, 2),
        'is_confirm'        => mt_rand(1, 2),
        'loan_amount'       => floatval($if),
        'product_name'      => str_random(20),
        'nper'              => mt_rand(1, 24),
        'annualized_return' => floatval($if),
        'gross_interest'    => floatval($if),
        'interest_monthly'  => floatval($if),
        'deduct_date'       => date('Y-m-d', mt_rand($start, $end)),
        'loan_date'         => date('Y-m-d', mt_rand($start, $end)),
        'due_date'          => date('Y-m-d', mt_rand($start, $end)),
        'billing_days'      => mt_rand(1, 30),
        'expire_days'       => mt_rand(1, 30),
        'status'            => mt_rand(1, 10),
        'client_info_id'    => function () {
            return factory(App\Model\ClientInfo::class)->create()->id;
        },
        'deleted_at'        => date('Y-m-d H:i:s', mt_rand($start, $end)),
        'created_at'        => mt_rand($start, $end),
        'updated_at'        => mt_rand($start, $end)
    ];
});
