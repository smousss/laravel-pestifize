<?php

namespace Smousss\Laravel\Pestifize\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Smousss\Laravel\Pestifize\PestifizeServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [PestifizeServiceProvider::class];
    }
}
