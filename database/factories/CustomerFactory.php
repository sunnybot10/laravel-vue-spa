<?php

use Faker\Generator as Faker;

$factory->define(App\Customer::class, function (Faker $faker) {
    return [
        'name'    	=> $faker->name ,
        'email'     => $faker->unique()->safeEmail,
        'phone'		=> $faker->phoneNumber,
        'address'	=> $faker->address,
        'birthday'  => $faker->date($format = 'Y-m-d', $max = 'now'),
    ];
});
