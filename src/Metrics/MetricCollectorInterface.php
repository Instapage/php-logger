<?php

declare(strict_types=1);

namespace Instapage\Metrics;

interface MetricCollectorInterface
{
    public function collect(string $metricName, $value): void;
}
