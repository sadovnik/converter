<?php

namespace Converter\Coders\Yaml;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Exception\DumpException;
use Converter\Result;

/**
 * @param array $array
 * @return string
 */
function encode(array $array)
{
    try {
        $result = Yaml::dump($array);
    } catch (DumpException $e) {
        return Result\error('Yaml encode error: ' . $e->getMessage());
    }
    return Result\success($result);
}

/**
 * @param string $yaml
 * @return array
 */
function decode($yaml)
{
    try {
        $result = Yaml::parse($yaml);
    } catch (ParseException $e) {
        return Result\error('Yaml decode error: ' . $e->getMessage());
    }
    return Result\success($result);
}
