<?php

namespace Converter\Tests;

use Result;
use Converter\Coders\Ini;

class IniCoderTest extends BaseIsomorphicCoderTest
{
    public $format = 'ini';

    public function decode($string)
    {
        return Result\valueOf(Ini\decode($string));
    }

    public function encode($array)
    {
        return Result\valueOf(Ini\encode($array));
    }
}
