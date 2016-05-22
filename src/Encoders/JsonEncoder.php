<?php

namespace Converter\Encoders;

/**
 * @return callable
 */
function JsonEncoder()
{
    $encode = function ($array) {
        return json_encode($array, JSON_PRETTY_PRINT);
    };

    return $encode;
}
