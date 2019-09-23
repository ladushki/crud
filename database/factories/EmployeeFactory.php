<?php

/** @var Factory $factory */

use App\Employee;
use App\Model;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName(),
        'last_name' => $faker->lastName,
        'phone' => $faker->phoneNumber,
        'email' => $faker->email,
    ];
});
