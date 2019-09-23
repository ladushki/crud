<?php

namespace Tests\Feature;

use App\Http\Requests\EmployeeRequest;
use Faker\Factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeRequestValidationTest extends TestCase
{
    use RefreshDatabase;

    /** @var \App\Http\Requests\CompanyRequest */
    private $rules;

    /** @var \Illuminate\Validation\Validator */
    private $validator;

    public function setUp(): void
    {
        parent::setUp();

        $this->validator = app()->get('validator');

        $this->rules = (new EmployeeRequest())->rules();
    }

    public function validationProvider()
    {
        /* WithFaker trait doesn't work in the dataProvider */
        $faker = Factory::create(Factory::DEFAULT_LOCALE);

        return [
            'request_should_fail_when_no_name_is_provided' => [
                'passed' => false,
                'data' => [
                    'email' => $faker->email()
                ]
            ],
            'request_should_fail_when_name_has_more_than_255_characters' => [
                'passed' => false,
                'data' => [
                    'first_name' => $faker->paragraph(100)
                ]
            ],
            'request_should_fail_when_last_name_has_more_than_255_characters' => [
                'passed' => false,
                'data' => [
                    'last_name' => $faker->paragraph(100)
                ]
            ],
            'request_should_pass_when_data_is_provided' => [
                'passed' => true,
                'data' => [
                    'first_name' => $faker->word(),
                    'last_name'  => $faker->word(),
                    'company_id'  => 1,
                ]
            ],
            'request_should_pass_when_data_is_provided' => [
                'passed' => true,
                'data' => [
                    'first_name' => $faker->word(),
                    'last_name' => $faker->word(),
                    'email' => $faker->email(),
                    'company_id'  => 1,
                ]
            ],
        ];
    }

    /**
     * @test
     * @dataProvider validationProvider
     * @param bool $shouldPass
     * @param array $mockedRequestData
     */
    public function test_validation_results_as_expected($shouldPass, $mockedRequestData)
    {
        $this->assertEquals(
            $shouldPass,
            $this->validate($mockedRequestData)
        );
    }

    protected function validate($mockedRequestData)
    {
        return $this->validator
            ->make($mockedRequestData, $this->rules)
            ->passes();
    }
}
