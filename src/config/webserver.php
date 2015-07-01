<?php
/**
 * All hyn-me/webserver related configuration options
 * @warning please be advised, read the documentation on http://hyn.me before editing
 *
 * None of the generated configurations will work as long as you don't add the paths to the corresponding webservice
 * configuration file. See documentation for more info.
 */
return [
    'webservers' => ['nginx', 'apache'],

    'group' => 'www-data',
    'ssl' => [
        'path' => storage_path('webserver/ssl')
    ],
    /*
     * Apache
     */
    'apache' => [
        'path' => storage_path('webserver/apache/'),
        // class that runs functionality for this service
        'class' => 'HynMe\Webserver\Generators\Webserver\Apache',
        'enabled' => true,
        'port' => [
            'http' => 80,
            'https' => 443,
        ],
        'configtest' => 'apache2ctl -t',
        // path to service daemon
        'service' => '/etc/init.d/apache2',
        // system wide configuration directory
        'conf' => [
            // location for ubuntu 14.04 systems
            '/etc/apache2/sites-enabled/'
        ],
        // mask for auto-generated config file that includes the tenant configurations
        'mask' => '%s.conf',
        // include format using sprintf
        'include' => 'IncludeOptional %s*'
    ],
    /*
     * Nginx
     */
    'nginx' => [
        'path' => storage_path('webserver/nginx/'),
        'class' => 'HynMe\Webserver\Generators\Webserver\Nginx',
        'enabled' => true,
        'port' => [
            'http' => 80,
            'https' => 443
        ],
        'service' => '/etc/init.d/nginx',
        'conf' => ['/etc/nginx/sites-enabled/'],
        'mask' => '%s.conf',
        'include' => 'include %s*;',
        // other services this service depends on
        'depends' => [
            'fpm'
        ]
    ],
    /*
     * PHP FPM
     */
    'fpm' => [
        'path' => storage_path('webserver/fpm/'),
        'class' => 'HynMe\Webserver\Generators\Webserver\Fpm',
        'enabled' => true,
        /*
         * base modifier for fpm pool port
         * @example if base is 9000, will generate pool file for website Id 5 with port 9005
         * @info this port is used in Nginx configurations for the PHP proxy
         */
        'conf' => ['/etc/php5/fpm/pool.d/'],
        'mask' => '%s.conf',
        'port' => 9000,
        'configtest' => 'php5-fpm -t'
    ]
];