<?php
namespace Postclick\Metrics;

interface MetricCollectorInterface
{
    public function collect(string $metricName, $value): void;
}
