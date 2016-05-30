<?php

namespace Converter\Coders\Ini;

use Converter\Result;
use Piwik\Ini\IniReader;
use Piwik\Ini\IniWriter;

/**
 * @param array $array
 * @return callable
 */
function encode(array $array)
{
    return Result\tryCatch(function () use ($array) {
        return (new IniWriter)->writeToString($array);
    });
}

/**
 * @param string $ini
 * @return callable
 */
function decode($ini)
{
    return Result\tryCatch(function () use ($ini) {
        return (new IniReader)->readString($ini);
    });
}
