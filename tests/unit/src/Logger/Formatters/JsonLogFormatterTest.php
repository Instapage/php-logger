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
                [
                    'channel' => 'app',
                    'message' => 'lead submitted',
                    'level' => 200,
                    'level_name' => 'INFO',
                    'context' => [],
                ],
                json_encode([
                    'sChannel' => 'app',
                    'sType' => 'log',
                    'sMessage' => 'lead submitted',
                    'iLevel' => 200,
                    'sLevelName' => 'INFO',
                    'oContext' => new stdClass(),
                ]) . PHP_EOL
            ],
            'simple log' => [
                [
                    'channel' => 'app',
                    'message' => 'lead submitted',
                    'level' => 200,
                    'level_name' => 'INFO',
                    'context' => [
                        'leadID' => 123,
                    ],
                ],
                json_encode([
                    'sChannel' => 'app',
                    'sType' => 'log',
                    'sMessage' => 'lead submitted',
                    'iLevel' => 200,
                    'sLevelName' => 'INFO',
                    'oContext' => [
                        'iLeadID' => 123,
                    ],
                ]) . PHP_EOL,
            ],
            'log with complex nested context #1' => [
                [
                    'channel' => 'app',
                    'message' => 'User created',
                    'level' => 100,
                    'level_name' => 'DEBUG',
                    'context' => [
                        'id' => 1,
                        'name' => 'John',
                        'admin' => false,
                        'permissions' => [
                            'read' => true,
                            'write' => false,
                            'customReadSizeLimit' => 4,
                        ],
                        'morePermissions' => (object) [
                            'connect' => 'yes',
                            'disconnect' => 'no',
                        ],
                    ],
                ],
                json_encode([
                    'sChannel' => 'app',
                    'sType' => 'log',
                    'sMessage' => 'User created',
                    'iLevel' => 100,
                    'sLevelName' => 'DEBUG',
                    'oContext' => [
                        'iId' => 1,
                        'sName' => 'John',
                        'bAdmin' => false,
                        'aPermissions' => [
                            'bRead' => true,
                            'bWrite' => false,
                            'iCustomReadSizeLimit' => 4,
                        ],
                        'oMorePermissions' => [
                            'sConnect' => 'yes',
                            'sDisconnect' => 'no',
                        ],
                    ],
                ]) . PHP_EOL,
            ],
            'log with complex nested context #2' => [
                [
                    'channel' => 'app',
                    'message' => 'User permissions',
                    'level' => 100,
                    'level_name' => 'DEBUG',
                    'context' => [
                        'read' => [
                            0 => 'this',
                            1 => 'that',
                        ],
                        'write' => [
                            'this-too',
                            'also-that',
                        ],
                        'ids' => [
                            42,
                            69,
                        ],
                    ],
                ],
                json_encode([
                    'sChannel' => 'app',
                    'sType' => 'log',
                    'sMessage' => 'User permissions',
                    'iLevel' => 100,
                    'sLevelName' => 'DEBUG',
                    'oContext' => [
                        'aRead' => [
                            's0' => 'this',
                            's1' => 'that',
                        ],
                        "aWrite" => [
                            's0' => 'this-too',
                            's1' => 'also-that',
                        ],
                        "aIds" => [
                            'i0' => 42,
                            'i1' => 69,
                        ],
                    ],
                ]) . PHP_EOL,
            ],
            'log with complex nested context and requestId in extras #2' => [
                [
                    'channel' => 'app',
                    'message' => 'User permissions',
                    'level' => 100,
                    'level_name' => 'DEBUG',
                    'context' => [
                        'read' => [
                            0 => 'this',
                            1 => 'that',
                        ],
                        'write' => [
                            'this-too',
                            'also-that',
                        ],
                        'ids' => [
                            42,
                            69,
                        ],
                    ],
                    'extra' => [
                        'ipRequestId' => 'c91d4aa1-bf6c-4151-88ac-3ee0af8bbe28',
                    ]
                ],
                json_encode([
                    'sChannel' => 'app',
                    'sType' => 'log',
                    'sMessage' => 'User permissions',
                    'iLevel' => 100,
                    'sLevelName' => 'DEBUG',
                    'oContext' => [
                        'aRead' => [
                            's0' => 'this',
                            's1' => 'that',
                        ],
                        "aWrite" => [
                            's0' => 'this-too',
                            's1' => 'also-that',
                        ],
                        "aIds" => [
                            'i0' => 42,
                            'i1' => 69,
                        ],
                    ],
                    'sIpRequestId' => 'c91d4aa1-bf6c-4151-88ac-3ee0af8bbe28',
                ]) . PHP_EOL,
            ],
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
