<?php

declare(strict_types=1);

namespace Instapage\Metrics\Formatters;

use Monolog\Formatter\JsonFormatter;

class JsonMetricFormatter extends JsonFormatter
{
    public function format(array $record): string
    {
        $normalized = $this->normalize($record);

        // Available fields here - https://github.com/Seldaek/monolog/blob/main/doc/message-structure.md
        // We can change keys below
        $data = [
            'sChannel' => (string) $normalized['channel'], // string
            'sType' => 'metric', // string
            'sMetricName' => (string) $normalized['context']['metricName'] //string
        ];

        $fieldName = $this->getFieldName($normalized['context']['value']);
        $data[$fieldName] = $normalized['context']['value'];

        return $this->toJson($data, true) . ($this->appendNewline ? "\n" : '');
    }

    public function getFieldName($fieldValue, string $fieldNameSuffix = 'Value'): string
    {
        // https://en.wikipedia.org/wiki/JSON#Data_types
        // https://www.php.net/manual/en/function.gettype.php
        $types = [
            'string' => 's',
            'integer' => 'i',
            'double' => 'f',
            'array' => 'a',
            'object' => 'o',
            'boolean' => 'b',
            'NULL' => 'n'
        ];
        $type = gettype($fieldValue);
        return !isset($types[$type]) ? 'x' . $fieldNameSuffix : $types[$type] . $fieldNameSuffix;
    }
}
