<?php

declare(strict_types=1);

namespace Instapage\Logger\Factory;

use Monolog\Logger;
use Instapage\Logger\Formatters\JsonLogFormatter;
use Instapage\Logger\Handlers\StreamHandler;
use Psr\Log\LoggerInterface;

class LoggerFactory
{
    public function create($channel, $level = Logger::INFO): LoggerInterface
    {
        $formatter = new JsonLogFormatter();

        $handler = new StreamHandler($level);
        $handler->setFormatter($formatter);

        $logger = new Logger($channel);
        $logger->pushHandler($handler);

        return $logger;
    }
}
