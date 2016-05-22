<?php

namespace Converter;

use function Converter\Encoders\JsonEncoder;

class JsonEncoderTest extends \PHPUnit_Framework_TestCase
{
    protected $encoder;

    protected function setUp()
    {
        $this->encoder = JsonEncoder();
    }

    /**
     * @dataProvider provider
     */
    public function test($expect, $input)
    {
        $this->assertEquals($expect, $this->encoder->__invoke($input));
    }

    public function provider()
    {
        $json1 = <<<EOL
{
    "key": "value"
}
EOL;
        $json2 = <<<EOL
{
    "key": {
        "foo": "bar"
    }
}
EOL;
        $json3 = <<<EOL
{
    "key": [
        1,
        "hi",
        false,
        {
            "key": "value"
        }
    ]
}
EOL;
        $json4 = <<<EOL
{
    "key": null
}
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
