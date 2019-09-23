<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Contracts\Console\Kernel;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $baseUrl = 'http://localhost';

    public function setUp(): void
    {
        touch('./tests.sqlite');
        parent::setUp();

    }

    public function tearDown(): void
    {
        unlink('./tests.sqlite');
    }

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
