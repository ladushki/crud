<?php

use App\Company;
use App\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CompaniesEmployesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!File::isDirectory('app/public')){
            File::makeDirectory(storage_path('app/public'), 0777, true, true);
        }
        factory(Company::class, 20)->create()->each(function ($company) {
            $rand = rand(1, 4);
            for ($i = 0; $i < $rand; $i++) {
                $company->employees()->save(factory(Employee::class)->make());
            }
        });
    }
}
