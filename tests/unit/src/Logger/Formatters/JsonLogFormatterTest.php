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
            'log with empty context' => [
                ['channel' => 'app', 'message' => 'lead submitted', 'level' => 200, 'level_name' => 'INFO', 'context' => []],
                json_encode(['sChannel' => 'app', 'sType' => 'log', 'sMessage' => 'lead submitted', 'iLevel' => 200, 'sLevelName' => 'INFO', 'oContext' => new stdClass()]) . "\n"
            ],
            'simple log' => [
                ['channel' => 'app', 'message' => 'lead submitted', 'level' => 200, 'level_name' => 'INFO', 'context' => ['leadID' => 123]],
                json_encode(['sChannel' => 'app', 'sType' => 'log', 'sMessage' => 'lead submitted', 'iLevel' => 200, 'sLevelName' => 'INFO', 'oContext' => ['iLeadID' => 123]]) . "\n"
            ],
            'log with complex nested context' => [
                ['channel' => 'app', 'message' => 'User created', 'level' => 100, 'level_name' => 'DEBUG', 'context' => ['id' => 1, 'name' => 'John', 'admin' => false, 'permissions' => ['read' => true, 'write' => false, 'customReadSizeLimit' => 4], 'morePermissions' => (object) ['connect' => 'yes', 'disconnect' => 'no']]],
                json_encode(['sChannel' => 'app', 'sType' => 'log', 'sMessage' => 'User created', 'iLevel' => 100, 'sLevelName' => 'DEBUG', 'oContext' => ['iId' => 1, 'sName' => 'John', 'bAdmin' => false, 'aPermissions' => ['bRead' => true, 'bWrite' => false, 'iCustomReadSizeLimit' => 4], 'oMorePermissions' => ['sConnect' => 'yes', 'sDisconnect' => 'no']]]) . "\n"
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
