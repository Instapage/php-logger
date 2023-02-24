<?php

declare(strict_types=1);

namespace Instapage\Metrics;

use Psr\Log\LoggerInterface;

class MetricCollector implements MetricCollectorInterface
{
    /** @var LoggerInterface */
    private $logger;

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
