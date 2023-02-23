<?php
namespace Postclick\Metrics;

use Psr\Log\LoggerInterface;

class MetricCollector implements MetricCollectorInterface
{
    private LoggerInterface $logger;

    public function __construct(
        LoggerInterface $logger
    ) {
        $this->logger = $logger;
    }

    public function collect(string $metricName, $value): void
    {
        $this->logger->debug('Metric collected', [
            'metricName' => $metricName,
            'value' => $value
        ]);
    }
}
