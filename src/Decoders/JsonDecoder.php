<?php

namespace Converter\Decoders;

/**
 * @return callable
 */
function JsonDecoder()
{
    $decode = function ($json) {
        return json_decode($json, true);
    };
    return $decode;
}
