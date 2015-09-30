<?php namespace HynMe\Webserver\Tests;

use Laraflock\MultiTenant\Models\Website;
use Mockery;
use HynMe\Framework\Testing\TestCase;

class WebsiteUserTest extends TestCase {
    public function testCallCommand() {
        $mock = new Mockery(Website::class);
    }
}