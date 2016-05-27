<?php

namespace Converter;

use function Converter\Result\getValue;
use Converter\Coders\Ini;

class IniCoderTest extends BaseIsomorphicCoderTest
{
    public $format = 'ini';

    public function decode($string)
    {
        return getValue(Ini\decode($string));
    }

    public function encode($array)
    {
        return getValue(Ini\encode($array));
    }
}
