<?php
namespace Postclick\Metrics\Factory;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Postclick\Metrics\Formatters\JsonMetricFormatter;
use Postclick\Metrics\MetricCollector;
use Postclick\Metrics\MetricCollectorInterface;

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
