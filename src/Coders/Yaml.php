<?php

namespace Converter\Coders\Yaml;

use Symfony\Component\Yaml\Yaml;
use Result;

/**
 * @param array $array
 * @return callable
 */
function encode(array $array)
{
    return Result\tryCatch(function () use ($array) {
        return Yaml::dump($array);
    });
}

/**
 * @param string $yaml
 * @return callable
 */
function decode($yaml)
{
    return Result\tryCatch(function () use ($yaml) {
        return Yaml::parse($yaml);
    });
}
