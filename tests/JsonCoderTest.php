<?php

namespace Converter;

use Converter\Coders\Json;
use function Converter\Result\getValue;

class JsonCoderTest extends BaseIsomorphicCoderTest
{
    public $format = 'json';

    public function decode($string)
    {
        return getValue(Json\decode($string));
    }

    public function encode($array)
    {
        return getValue(Json\encode($array));
    }
}
