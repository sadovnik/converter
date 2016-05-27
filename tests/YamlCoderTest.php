<?php

namespace Converter;

use function Converter\Result\getValue;
use Converter\Coders\Yaml;

class YamlCoderTest extends BaseIsomorphicCoderTest
{
    public $format = 'yaml';

    public function decode($string)
    {
        return getValue(Yaml\decode($string));
    }

    public function encode($array)
    {
        return getValue(Yaml\encode($array));
    }
}
