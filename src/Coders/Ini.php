<?php

namespace Converter\Coders\Ini;

use function Converter\Utils\isClosure;
use Converter\Result;

/**
 * @param array $array
 * @return string
 */
function encode(array $array)
{
    $reducer = function ($array, $level) use (&$reducer) {
        return array_reduce(
            array_keys($array),
            function ($acc, $key) use ($array, $level, $reducer) {
                if (isClosure($acc)) {
                    return $acc;
                }
                if (is_array($array[$key])) {
                    if ($level > 0) {
                        return Result\error('Couldn\'t convert array with more than one nesting level');
                    }
                    return $acc . "[$key]" . PHP_EOL . $reducer($array[$key], $level + 1);
                } else {
                    $value = $array[$key];
                    if ($value === true) {
                        $value = 'yes';
                    } elseif ($value === false) {
                        $value = 'no';
                    }
                    return $acc . $key . '=' . $value . PHP_EOL;
                }
            },
            ''
        );
    };

    $result = $reducer($array, 0);
    return isClosure($result) ? $result : Result\success($result);
}

/**
 * @param string $ini
 * @return array
 */
function decode($ini)
{
    $result = parse_ini_string($ini, true, INI_SCANNER_TYPED);
    if ($result === false) {
        return Result\error('Couldn\'t parse ini. Please check syntax');
    }
    return Result\success($result);
}
