<?php

namespace Hyn\Webserver\Tests;

use Hyn\Webserver\Commands\WebserverCommand;
use Illuminate\Database\Eloquent\Factory;
use Laraflock\MultiTenant\Models\Website;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Contracts\Console\Kernel;
use Faker\Generator;
use Laraflock\MultiTenant\Contracts\WebsiteRepositoryContract;
use Mockery;

class WebsiteUserTest extends TestCase
{
    /**
     * Tests the functionality of creating.
     */
    public function testWebserverCommandCreate()
    {
        $command = new WebserverCommand(1, 'create');

        $command->handle();
    }

    /**
     * Creates the application.
     *
     * Needs to be implemented by subclasses.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../vendor/laravel/laravel/bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        $app->singleton(Factory::class, function () {
            return Factory::construct(new Generator(), __DIR__.'/../database/factories');
        });

        $app['config']->set('database.connections.tenant', [
            'driver' => 'pgsql',
            'database' => 'tenant-pgsql'
        ]);

        $app['config']->set('database.connections.hyn', [
            'driver' => 'pgsql',
            'database' => 'hyn'
        ]);

        $app['config']->set('database.default', 'hyn');

        return $app;
    }

    /**
     * Sets up prerequisites.
     */
    public function setUp()
    {
        parent::setUp();

        $websiteRepositoryMock = Mockery::mock(WebsiteRepositoryContract::class);

        $website = factory(Website::class)->make();

        $websiteRepositoryMock->shouldReceive('findById')->with(1)->andReturn($website);

        $this->app->instance(WebsiteRepositoryContract::class, $websiteRepositoryMock);
    }
}
