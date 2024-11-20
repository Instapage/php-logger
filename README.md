# instapage/php-logger - PHP logger & metrics

A library for standardized logs & metric format, based on [`monolog/monolog`](https://packagist.org/packages/monolog/monolog).

## Installation

Add this to `require` section:

```json
"instapage/php-logger": "1.5.1"
```

Alternatively, you can type `composer require instapage/php-logger:1.5.1`.

## Examples

Then add following code in your application:

```php
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
```

## Output

Each log is a single line. Multi-line here is only to improve readability.
Notice how field names change for metric depending on the type of value provided.

```json
{
    "sChannel":"my-service",
    "sType":"log",
    "sMessage":"User created",
    "iLevel":200,
    "sLevelName":"INFO",
    "oContext": {
        "iId":123,
        "sRole":"admin"
    }
}
```
```json
{
    "sChannel": "my-service.worker",
    "sType": "metric",
    "sMetricName": "Queue size",
    "iValue": 42
}
```
```json
{
    "sChannel": "my-service.worker",
    "sType": "metric",
    "sMetricName": "Memory used by worker (MB)",
    "fValue": 123.5
}
```

## How to run unit tests ?

```bash
composer test
```

## How to run linter ?

```bash
composer lint
# to automatically fix some of the most common errors
composer lint:fix
```

## Docker fan ?
You can also use following docker commands to try the package out:
 - `docker compose -f docker/docker-compose.yml up lint`
 - `docker compose -f docker/docker-compose.yml up lint:fix`
 - `docker compose -f docker/docker-compose.yml up test`
 - `docker compose -f docker/docker-compose.yml up example`

 `docker compose -f docker/docker-compose.yml down` will clean up nicely afterwards.
