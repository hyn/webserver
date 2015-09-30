<?php

$factory->define(Laraflock\MultiTenant\Models\Website::class, function (Faker\Generator $faker) {
    $faker->addProvider(Faker\Provider\Base::class);

    return [
        'id' => 1,
        'identifier' => $faker->regexify('[a-z_]{10}'),
        'tenant_id' => 1,
        'hostnamesWithCertificate' => new \Illuminate\Support\Collection(),
        'hostnamesWithoutCertificate' => new \Illuminate\Support\Collection(),
        'hostnames' => new \Illuminate\Support\Collection(),
    ];
});
