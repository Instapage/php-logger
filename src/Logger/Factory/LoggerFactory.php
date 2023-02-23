<?php
namespace Postclick\Logger\Factory;

use Monolog\Logger;
use Postclick\Logger\Formatters\JsonLogFormatter;
use Postclick\Logger\Handlers\StreamHandler;
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
