<?php

declare(strict_types=1);

namespace Instapage\Metrics\Formatters;

use Instapage\Shared\Formatters\JsonSharedFormatter;
use Monolog\Formatter\JsonFormatter;

class JsonMetricFormatter extends JsonFormatter
{
    use JsonSharedFormatter;

    public function format(array $record): string
    {
        $normalized = $this->normalize($record);

        // Available fields:
        // https://github.com/Seldaek/monolog/blob/main/doc/message-structure.md
        $data = [
            'sChannel' => (string) $normalized['channel'],
            'sType' => 'metric',
            'sMetricName' => (string) $normalized['context']['metricName']
        ];

        $fieldName = $this->getFieldName($normalized['context']['value']);
        $data[$fieldName] = $normalized['context']['value'];

        return $this->toJson($data, true) . ($this->appendNewline ? PHP_EOL : '');
    }
}
