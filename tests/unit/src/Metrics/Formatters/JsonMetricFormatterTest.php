<?php
declare(strict_types=1);
namespace Tests\Metrics\Formatters;

use PHPUnit\Framework\TestCase;
use Postclick\Metrics\Formatters\JsonMetricFormatter;

class JsonMetricFormatterTest extends TestCase
{
    public function metricProvider(): array
    {
        return [
            'string based metric' => [
                ['channel' => 'app', 'context' => ['metricName' => 'string metric', 'value' => 'abc']],
                json_encode(['sChannel' => 'app', 'sType' => 'metric', 'sMetricName' => 'string metric', 'sValue' => 'abc']) . "\n"
            ],
            'int based metric' => [
                ['channel' => 'app', 'context' => ['metricName' => 'int metric', 'value' => 123]],
                json_encode(['sChannel' => 'app', 'sType' => 'metric', 'sMetricName' => 'int metric', 'iValue' => 123]) . "\n"
            ],
            'float based metric' => [
                ['channel' => 'app', 'context' => ['metricName' => 'float metric', 'value' => 1.23]],
                json_encode(['sChannel' => 'app', 'sType' => 'metric', 'sMetricName' => 'float metric', 'fValue' => 1.23]) . "\n"
            ],
            'bool based metric' => [
                ['channel' => 'app', 'context' => ['metricName' => 'bool metric', 'value' => true]],
                json_encode(['sChannel' => 'app', 'sType' => 'metric', 'sMetricName' => 'bool metric', 'bValue' => true]) . "\n"
            ]
        ];
    }

    /**
     * @testdox Test the output of format() method
     * @dataProvider metricProvider
     */
    public function testFormat(array $input, string $expectedOutput): void
    {
        $formatter = new JsonMetricFormatter();
        $json = $formatter->format($input);

        $this->assertIsString($json);
        $this->assertEquals($expectedOutput, $json);
    }

    public function typeProvider(): array
    {
        return [
            'string' => ['abc', 'sValue'],
            'int' => [123, 'iValue'],
            'float' => [1.23, 'fValue'],
            'array' => [[], 'aValue'],
            'object' => [new \stdClass(), 'oValue'],
            'boolean' => [true, 'bValue'],
            'null' => [null, 'nValue']
        ];
    }

    /**
     * @testdox Test the output of getFieldName() method
     * @dataProvider typeProvider
     */
    public function testGetFieldName($input, string $expectedOutput): void
    {
        $formatter = new JsonMetricFormatter();
        $type = $formatter->getFieldName($input);

        $this->assertIsString($type);
        $this->assertEquals($expectedOutput, $type);
    }
}
