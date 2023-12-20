<?php

namespace Ride\Tests;

use Laravel\Lumen\Testing\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../app.php';
    }
}
