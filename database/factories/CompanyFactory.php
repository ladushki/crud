<?php

/** @var Factory $factory */

use App\Company;
use App\Model;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Company::class, function (Faker $faker) {
    $word = $faker->word;
    return [
        'name' => ucfirst($word),
        'logo' => $faker->image(storage_path('app/public'), 150, 150, null, false),
        'website' => 'https://' . $word . '.com',
        'email' => $faker->email,
    ];
});
