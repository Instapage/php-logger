<?php
namespace Tests\Logger\Factory;

use Postclick\Logger\Factory\LoggerFactory;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class LoggerFactoryTest extends TestCase
{
    public function testCreate()
    {
        $factory = new LoggerFactory();

        $logger = $factory->create('channel');

        $this->assertInstanceOf(LoggerInterface::class, $logger);
    }
}
