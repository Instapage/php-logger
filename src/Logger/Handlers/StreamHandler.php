<?php

declare(strict_types=1);

namespace Instapage\Logger\Handlers;

use Monolog\Logger;

class StreamHandler extends \Monolog\Handler\StreamHandler
{
    public function __construct(
        $level = Logger::DEBUG,
        bool $bubble = true,
        ?int $filePermission = null,
        bool $useLocking = false
    ) {
        parent::__construct(
            'php://stderr',
            $level,
            $bubble,
            $filePermission,
            $useLocking
        );
    }
}
