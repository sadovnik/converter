<?php

namespace Converter;

use function Converter\Decoders\JsonDecoder;

class JsonDecoderTest extends \PHPUnit_Framework_TestCase
{
    protected $decoder;

    protected function setUp()
    {
        $this->decoder = JsonDecoder();
    }

    /**
     * @dataProvider provider
     */
    public function test($input, $expect)
    {
        $this->assertEquals($expect, $this->decoder->__invoke($input));
    }

    public function provider()
    {
        $json1 = <<<EOL
{"key": "value"}
EOL;
        $json2 = <<<EOL
{"key": {"foo": "bar"}}
EOL;
        $json3 = <<<EOL
{"key": [1, "hi", false, {"key": "value"}]}
EOL;
        $json4 = <<<EOL
{"key": null}
EOL;
        return [
            [$json1, [
                'key' => 'value'
            ]],
            [$json2, [
                'key' => [
                    'foo' => 'bar'
                ]
            ]],
            [$json3, [
                'key' => [1, 'hi', false, ['key' => 'value']]
            ]],
            [$json4, [
                'key' => null
            ]]
        ];
    }
}
