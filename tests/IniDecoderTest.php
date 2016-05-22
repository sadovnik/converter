<?php

namespace Converter;

use function Converter\Decoders\IniDecoder;

class IniDecoderTest extends \PHPUnit_Framework_TestCase
{
    protected $decoder;

    protected function setUp()
    {
        $this->decoder = IniDecoder();
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
        $ini1 = <<<EOL
key=value

EOL;

        $ini2 = <<<EOL
good=yes
bad=no
account=10000

EOL;

        $ini3 = <<<EOL
[steve]
id=937628
age=23
verified=yes

[joey]
id=98263
age=18
verified=no

EOL;

        $ini4 = <<<EOL
key=value

[section]
anotherKey=anotherValue

EOL;
        return [
            [ $ini1, [ 'key' => 'value' ] ],
            [ $ini2, [
                'good' => true,
                'bad' => false,
                'account' => 10000
            ] ],
            [ $ini3, [
                'steve' => [
                    'id' => 937628,
                    'age' => 23,
                    'verified' => true
                ],
                'joey' => [
                    'id' => 98263,
                    'age' => 18,
                    'verified' => false
                ]
            ] ],
            [ $ini4, [
                'key' => 'value',
                'section' => [
                    'anotherKey' => 'anotherValue'
                ]
            ] ],
        ];
    }
}
