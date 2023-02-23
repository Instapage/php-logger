<?php
namespace Postclick\Logger\Formatters;

use Monolog\Formatter\JsonFormatter;

class JsonLogFormatter extends JsonFormatter
{
    public function format(array $record): string
    {
        $normalized = $this->normalize($record);

        if (isset($normalized['context']) && $normalized['context'] === []) {
            $normalized['context'] = new \stdClass;
        }

        // Available fields here - https://github.com/Seldaek/monolog/blob/main/doc/message-structure.md
        // We can change keys below
        $data = [
            'sChannel' => (string) $normalized['channel'], // string
            'sType' => 'log', // string
            'sMessage' => (string) $normalized['message'], // string
            'iLevel' => (int) $normalized['level'], // int
            'sLevelName' => (string) $normalized['level_name'], // string
            'oContext' => (object) $normalized['context'], // object
        ];

        return $this->toJson($data, true) . ($this->appendNewline ? "\n" : '');
    }
}
