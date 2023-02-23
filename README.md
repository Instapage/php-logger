[![Coverage](https://sonarqube-postclick.instamanagement.club/api/project_badges/measure?project=php-logger\&metric=coverage)](https://sonarqube-postclick.instamanagement.club/dashboard?id=php-logger)
[![Maintainability Rating](https://sonarqube-postclick.instamanagement.club/api/project_badges/measure?project=php-logger\&metric=sqale_rating)](https://sonarqube-postclick.instamanagement.club/dashboard?id=php-logger)
[![Security Rating](https://sonarqube-postclick.instamanagement.club/api/project_badges/measure?project=php-logger\&metric=security_rating)](https://sonarqube-postclick.instamanagement.club/dashboard?id=php-logger)
[![Vulnerabilities](https://sonarqube-postclick.instamanagement.club/api/project_badges/measure?project=php-logger\&metric=vulnerabilities)](https://sonarqube-postclick.instamanagement.club/dashboard?id=php-logger)

# @postclick/php-logger - PHP logger & metrics

A library for standardized logs & metric format, based on [`monolog/monolog`](https://packagist.org/packages/monolog/monolog).

## Table of contents

\[\[*TOC*]]

## Installation

Add new repository in `composer.json` (`repositories` key):

```json
"php-logger": {
  "name": "postclick/php-logger",
  "type": "path",
  "url": "/tmp/local-composer-packages/php-logger",
  "options": {
    "symlink": false,
    "versions": {
      "postclick/php-logger": "1.0.0"
    }
  }
}
```

Then add this to `require` section:

```json
"postclick/php-logger": "1.0.0"
```

Alternatively, you can type `composer require postclick/php-logger:1.0.0`.
Then add following code in your application:

```php
<?php

declare(strict_types=1);

use Postclick\Logger\Factory\LoggerFactory;
use Postclick\Metrics\Factory\MetricCollectorFactory;
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
$logger->info('User created', ['iID' => 123, 'sRole' => 'admin']);
$metric->collect('Memory used by worker (MB)', 123.50);
```

## Output

Each is the single line. Multi-line here is only to improve readability.

```json
{
  "sChannel": "my-service",
  "sType": "log",
  "iLevel": 200,
  "sLevelName": "INFO",
  "sMessage": "User created",
  "oContext": {
    "iID": 123,
    "sRole": "admin"
  }
}
```

```json
{
  "sChannel": "my-service.worker",
  "sType": "metric",
  "sMetricName": "Memory used by worker (MB)",
  "fValue": 123.50
}    
```

## How to run unit tests ?

```bash
# from monorepo root directory
 npm run --prefix packages/php-logger test:unit:text
```

Directory with HTML coverage report will be under `~/php-logger-coverage` on your local pc.

## How to run linter ?

```bash
# from monorepo root directory
npm run --prefix packages/php-logger lint
# to automatically fix some of the most common errors
npm run --prefix packages/php-logger lint:fix
```
