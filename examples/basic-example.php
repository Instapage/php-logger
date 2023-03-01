<?php

declare(strict_types=1);

use Instapage\Logger\Factory\LoggerFactory;
use Instapage\Metrics\Factory\MetricCollectorFactory;
use Monolog\Logger;

require_once dirname(__DIR__) . '/vendor/autoload.php';

// Preferably put these two on DI
$logger = (new LoggerFactory())->create(
    'my-service',
    Logger::DEBUG
);

$metric = (new MetricCollectorFactory())->create(
    'my-service.worker'
);

// Simple one-liner
$logger->info('User created', ['id' => 123, 'role' => 'admin']);
$metric->collect('Queue size', 42);
$metric->collect('Memory used by worker (MB)', 123.50);

// More complex log
$logger->info(
    'User created',
    [
        'id' => 1,
        'name' => 'John',
        'admin' => false,
        'permissions' => [
            'read' => true,
            'write' => false,
            'customReadSizeLimit' => 4
        ],
        'morePermissions' => (object) [
            'connect' => 'yes',
            'disconnect' => 'no'
        ],
    ]
);
