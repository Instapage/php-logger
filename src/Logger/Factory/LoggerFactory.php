<?php

declare(strict_types=1);

namespace Instapage\Logger\Factory;

use Monolog\Logger;
use Instapage\Logger\Formatters\JsonLogFormatter;
use Instapage\Logger\Handlers\StreamHandler;
use Psr\Log\LoggerInterface;

class LoggerFactory
{
    public function create($channel, $level = Logger::INFO, ?string $requestId = null): LoggerInterface
    {
        return $this->createWithExtras($channel, $level, ['ipRequestId' => $requestId]);
    }

    public function createWithExtras($channel, $level = Logger::INFO, array $extras = []): LoggerInterface
    {
        $formatter = new JsonLogFormatter();

        $handler = new StreamHandler($level);
        $handler->setFormatter($formatter);

        $logger = new Logger($channel);
        $logger->pushHandler($handler);

        $logger->pushProcessor(static function (array $record) use ($extras) {
            if (is_array($record['extra'])) {
                $record['extra'] = array_merge($record['extra'], $extras);
            } else {
                $record['extra'] = $extras;
            }

            return $record;
        });

        return $logger;
    }
}
