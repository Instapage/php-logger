<?php

declare(strict_types=1);

namespace Tests\Logger\Formatters;

use PHPUnit\Framework\TestCase;
use Instapage\Logger\Formatters\JsonLogFormatter;
use stdClass;

class JsonLogFormatterTest extends TestCase
{
    public function dataProvider(): array
    {
        return [
            'simple log' => [
                ['channel' => 'app', 'message' => 'lead submitted', 'level' => 200, 'level_name' => 'INFO' ,'context' => ['iLeadID' => 123]],
                json_encode(['sChannel' => 'app', 'sType' => 'log', 'sMessage' => 'lead submitted', 'iLevel' => 200, 'sLevelName' => 'INFO', 'oContext' => ['iLeadID' => 123]]) . "\n"
            ],
            'log with empty context' => [
                ['channel' => 'app', 'message' => 'lead submitted', 'level' => 200, 'level_name' => 'INFO' ,'context' => []],
                json_encode(['sChannel' => 'app', 'sType' => 'log', 'sMessage' => 'lead submitted', 'iLevel' => 200, 'sLevelName' => 'INFO', 'oContext' => new stdClass()]) . "\n"
            ]
        ];
    }

    /**
     * @testdox Test the output of format() method
     * @dataProvider dataProvider
     */
    public function testFormat(array $input, string $expectedOutput): void
    {
        $formatter = new JsonLogFormatter();
        $json = $formatter->format($input);

        $this->assertIsString($json);
        $this->assertEquals($expectedOutput, $json);
    }
}
