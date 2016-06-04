<?php

namespace Converter;

use Result;
use Converter\Coders\Yaml;

class YamlCoderTest extends BaseIsomorphicCoderTest
{
    public $format = 'yaml';

    public function decode($string)
    {
        return Result\valueOf(Yaml\decode($string));
    }

    public function encode($array)
    {
        return Result\valueOf(Yaml\encode($array));
    }
}
