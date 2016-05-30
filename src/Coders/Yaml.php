<?php

namespace Converter\Coders\Yaml;

use Symfony\Component\Yaml\Yaml;
use Converter\Result;

/**
 * @param array $array
 * @return callable either Result\success or Result\error instance
 */
function encode(array $array)
{
    return Result\tryCatch(function () use ($array) {
        return Yaml::dump($array);
    });
}

/**
 * @param string $yaml
 * @return callable either Result\success or Result\error instance
 */
function decode($yaml)
{
    return Result\tryCatch(function () use ($yaml) {
        return Yaml::parse($yaml);
    });
}
