<?php
namespace Tests\Metrics\Factory;

use Postclick\Metrics\Factory\MetricCollectorFactory;
use PHPUnit\Framework\TestCase;
use Postclick\Metrics\MetricCollectorInterface;

class MetricCollectorFactoryTest extends TestCase
{
    public function testCreate()
    {
        $factory = new MetricCollectorFactory();

        $metricCollector = $factory->create('channel');

        $this->assertInstanceOf(MetricCollectorInterface::class, $metricCollector);
    }
}
