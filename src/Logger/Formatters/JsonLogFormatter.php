<?php

declare(strict_types=1);

namespace Instapage\Logger\Formatters;

use Instapage\Shared\Formatters\JsonSharedFormatter;
use Monolog\Formatter\JsonFormatter;
use stdClass;

class JsonLogFormatter extends JsonFormatter
{
    use JsonSharedFormatter;

    public function format(array $record): string
    {
        $normalized = $this->normalize($record);

        if (isset($normalized['context']) && $normalized['context'] === []) {
            $normalized['context'] = new stdClass();
        }

        // Available fields:
        // https://github.com/Seldaek/monolog/blob/main/doc/message-structure.md
        $data = [
            'sChannel' => (string) $normalized['channel'],
            'sType' => 'log',
            'sMessage' => (string) $normalized['message'],
            'iLevel' => (int) $normalized['level'],
            'sLevelName' => (string) $normalized['level_name'],
            'oContext' => $this->getNestedField((array) $normalized['context']),
        ];

        foreach ($normalized['extra'] as $key => $value) {
            $data["s{$key}"] = (string) $value;
        }

        return $this->toJson($data, true) . ($this->appendNewline ? PHP_EOL : '');
    }

    protected function getNestedField(array $context = []): object
    {
        $formattedContext = [];
        foreach ($context as $fieldName => $fieldValue) {
            $formattedFieldName = (is_string($fieldName)) ? ucfirst($fieldName) : $fieldName;
            $formattedFieldName = $this->getFieldName($context[$fieldName], $formattedFieldName);
            if (is_object($fieldValue)) {
                $fieldValue = (array) $fieldValue;
            }
            $formattedContext[$formattedFieldName] =
                is_array($fieldValue) ?
                $this->getNestedField($fieldValue) :
                $fieldValue;
        }
        return (object) $formattedContext;
    }
}
