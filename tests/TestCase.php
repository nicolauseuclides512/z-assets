<?php

use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    public function isValidationPass($some_model, $field)
    {
        #if errors = empty
        if (empty($some_model['errors'])) {
            return true;
        }

        #get error_message from validation
        $error_messages = $some_model['errors']->messages();
        if (empty($error_messages[$field])) {
            return true;
        } else {
            return false;
        }
    }

    protected function setUp()
    {
        parent::setUp();
        Artisan::call('migrate');
    }

    protected function tearDown()
    {
        Artisan::call('migrate:reset');
        parent::tearDown();
    }
}
