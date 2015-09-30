<?php

$factory->define(Laraflock\MultiTenant\Models\Hostname::class, function (Faker\Generator $faker) {
    return [
        'id' => 1,
        'website_id' => 1,
        'tenant_id' => 1,
    ];
});
