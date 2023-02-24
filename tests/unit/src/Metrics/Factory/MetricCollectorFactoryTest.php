<?php

declare(strict_types=1);

namespace Tests\Metrics\Factory;

use Instapage\Metrics\Factory\MetricCollectorFactory;
use PHPUnit\Framework\TestCase;
use Instapage\Metrics\MetricCollectorInterface;

class MetricCollectorFactoryTest extends TestCase
{
    public function testCreate()
    {
        $factory = new MetricCollectorFactory();

        $metricCollector = $factory->create('channel');

        $this->assertInstanceOf(MetricCollectorInterface::class, $metricCollector);
    }
}
