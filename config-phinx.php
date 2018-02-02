<?php

require 'vendor/autoload.php';
$config = require 'src/settings.php';

return [
    'paths' => [
        'migrations' => 'migrations'
    ],
    'migration_base_class' => '\Fullstackersio\Migration\Migration',
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'dev',
        'dev' => [
            'adapter' => getenv('DB_DRIVER'),
            'host' => getenv('DB_HOST'),
            'name' => getenv('DB_NAME'),
            'user' => getenv('DB_USER'),
            'pass' => getenv('DB_PASSWORD'),
            'port' => getenv('DB_PORT')
        ]
    ]
];