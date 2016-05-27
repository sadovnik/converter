<?php

namespace Converter\Coders\Json;

use Converter\Result;

/**
 * @param array $array
 * @return string
 */
function encode(array $array)
{
    $result = json_encode($array, JSON_PRETTY_PRINT);
    if ($result === null) {
        return Result\error('Couldn\'t encode json: ' . json_last_error_msg());
    }
    return Result\success($result);
}

/**
 * @param string $json
 * @return array
 */
function decode($json)
{
    $result = json_decode($json, true);
    if ($result === null) {
        return Result\error('Couldn\'t decode json: ' . json_last_error_msg());
    }
    return Result\success($result);
}
