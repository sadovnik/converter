<?php

namespace Converter\Encoders;

/**
 * @return callable
 */
function IniEncoder()
{
    $encode = function ($array) {
        $reducer = function ($array, $level) use (&$reducer) {
            return array_reduce(
                array_keys($array),
                function ($acc, $key) use ($array, $level, $reducer) {
                    if (is_array($array[$key])) {
                        if ($level > 0) {
                            die('Unvalid array');
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

        return $reducer($array, 0);
    };

    return $encode;
}
