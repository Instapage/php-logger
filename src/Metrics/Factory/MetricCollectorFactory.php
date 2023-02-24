<?php

declare(strict_types=1);

namespace Instapage\Metrics\Factory;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Instapage\Metrics\Formatters\JsonMetricFormatter;
use Instapage\Metrics\MetricCollector;
use Instapage\Metrics\MetricCollectorInterface;

class MetricCollectorFactory
{
    public function create(string $channel): MetricCollectorInterface
    {
        $formatter = new JsonMetricFormatter();

        $handler = new StreamHandler('php://stderr', Logger::DEBUG);
        $handler->setFormatter($formatter);

        $logger = new Logger($channel);
        $logger->pushHandler($handler);

        return new MetricCollector($logger);
    }
}
