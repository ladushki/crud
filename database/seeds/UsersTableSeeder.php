<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        \App\User::updateOrCreate(['email' => 'admin@admin.com',], [
            'name' => $faker->name,
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);
    }
}
