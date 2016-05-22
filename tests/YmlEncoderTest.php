<?php

namespace Converter;

use function Converter\Encoders\YmlEncoder;

class YmlEncoderTest extends \PHPUnit_Framework_TestCase
{
    protected $encoder;

    protected function setUp()
    {
        $this->encoder = YmlEncoder();
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
        $yml1 = <<<EOL
---
foo: bar
...

EOL;
        $yml2 = <<<EOL
---
foo:
- bar
- baz
- qux
...

EOL;
        $yml3 = <<<EOL
---
- name: Install PHP
  yum: pkg=item enablerepo=remi,remi-php56 state=present
  with_items:
  - php
  - php-common
...

EOL;
        return [
            [$yml1, ['foo' => 'bar']],
            [$yml2, ['foo' => ['bar', 'baz', 'qux']]],
            [$yml3, [
                [
                    'name' => 'Install PHP',
                    'yum' => 'pkg=item enablerepo=remi,remi-php56 state=present',
                    'with_items' => ['php', 'php-common']
                ]
            ]]
        ];
    }
}
