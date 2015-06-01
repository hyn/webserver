<?php
/**
 * All hyn-me/webserver related configuration options
 * @warning please be advised, read the documentation on http://hyn.me before editing
 *
 * None of the generated configurations will work as long as you don't add the paths to the corresponding webservice
 * configuration file. See documentation for more info.
 */
return [
    /*
     * Paths for configuration files
     */
    'paths' => [
        'fpm' => storage_path('webserver/fpm/'),
        'apache' => storage_path('webserver/apache/'),
        'nginx' => storage_path('webserver/nginx/'),
        'ssl' => storage_path('webserver/ssl/'),
    ],
    /*
     * Apache
     */
    'apache' => [
        'enabled' => true,
        'port' => [
            'http' => 8080,
            'https' => 8443,
        ]
    ],
    /*
     * Nginx
     */
    'nginx' => [
        'enabled' => true,
        'port' => [
            'http' => 80,
            'https' => 443,
        ]
    ],
    /*
     * PHP FPM
     */
    'fpm' => [
        'enabled' => true,
        /*
         * base modifier for fpm pool port
         * @example if base is 9000, will generate pool file for website Id 5 with port 9005
         */
        'port' => 9000
    ]
];