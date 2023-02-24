<?php

declare(strict_types=1);

namespace Tests\Metrics;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Instapage\Metrics\MetricCollector;
use Instapage\Metrics\MetricCollectorInterface;
use Psr\Log\LoggerInterface;

class MetricCollectorTest extends TestCase
{
    /**
     * @var MockObject|LoggerInterface;
     */
    private $loggerMock;

    public function setUp(): void
    {
        $this->loggerMock = $this->createMock(LoggerInterface::class);
    }

    /**
     * @testdox Test the collect() method
     */
    public function testMetricCollector(): void
    {
        $metricName = 'some metric';
        $metricValue = 123;

        $this->loggerMock
            ->expects($this->once())
            ->method('debug')
            ->with(
                $this->equalTo('Metric collected'),
                $this->equalTo(['metricName' => $metricName, 'value' => $metricValue])
            );

        $metricCollector = new MetricCollector($this->loggerMock);
        $metricCollector->collect($metricName, $metricValue);
        $this->assertInstanceOf(MetricCollectorInterface::class, $metricCollector);
    }
}
