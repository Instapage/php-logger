<?php

namespace Tests\Logger\Factory;

use Instapage\Logger\Factory\LoggerFactory;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class LoggerFactoryTest extends TestCase
{
    public function testCreate()
    {
        $factory = new LoggerFactory();

        $logger = $factory->create('channel', Logger::INFO, 'dee91e6b-7ec1-45cd-8401-2fdd4724c908');

        $this->assertInstanceOf(LoggerInterface::class, $logger);
    }
}
