<?php

declare(strict_types=1);

namespace Instapage\Shared\Formatters;

trait JsonSharedFormatter
{
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
