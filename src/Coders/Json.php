<?php

namespace Converter\Coders\Json;

use Result;

/**
 * @param array $array
 * @return callable
 */
function encode(array $array)
{
    $result = json_encode($array, JSON_PRETTY_PRINT);
    if ($result === null) {
        return Result\fail('Couldn\'t encode json: ' . json_last_error_msg());
    }
    return Result\ok($result);
}

/**
 * @param string $json
 * @return callable
 */
function decode($json)
{
    $result = json_decode($json, true);
    if ($result === null) {
        return Result\fail('Couldn\'t decode json: ' . json_last_error_msg());
    }
    return Result\ok($result);
}
