<?php

namespace Tests\Feature;

use App\Http\Requests\CompanyRequest;
use Faker\Factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyRequestValidationTest extends TestCase
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

        $this->rules = (new CompanyRequest())->rules();
    }

    public function validationProvider()
    {
        /* WithFaker trait doesn't work in the dataProvider */
        $faker = Factory::create(Factory::DEFAULT_LOCALE);

        return [
            'request_should_fail_when_no_name_is_provided' => [
                'passed' => false,
                'data' => [
                    'website' => $faker->word()
                ]
            ],
            'request_should_fail_when_name_has_more_than_255_characters' => [
                'passed' => false,
                'data' => [
                    'name' => $faker->paragraph(100)
                ]
            ],
            'request_should_pass_when_data_is_provided' => [
                'passed' => true,
                'data' => [
                    'name' => $faker->word(),
                ]
            ],
            'request_should_pass_when_data_is_provided' => [
                'passed' => true,
                'data' => [
                    'name' => $faker->word(),
                    'email' => $faker->email(),
                    'website' => $faker->url(),
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
