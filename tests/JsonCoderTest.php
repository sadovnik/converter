<?php

namespace Converter\Tests;

use Result;
use Converter\Coders\Json;

class JsonCoderTest extends BaseIsomorphicCoderTest
{
    public $format = 'json';

    public function decode($string)
    {
        return Result\valueOf(Json\decode($string));
    }

    public function encode($array)
    {
        return Result\valueOf(Json\encode($array));
    }

    public function testFailDecode()
    {
        $corruptedJson = '{"foo": bar"}';
        $result = Json\decode($corruptedJson);
        $this->assertTrue(Result\isFail($result));
    }
}
