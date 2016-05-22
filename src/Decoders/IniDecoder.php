<?php

namespace Converter\Decoders;

/**
 * @return callable
 */
function IniDecoder()
{
    $decode = function ($ini) {
        return parse_ini_string($ini, true, INI_SCANNER_TYPED);
        // return parse_ini_string($ini, true, INI_SCANNER_RAW);
    };
    return $decode;
}
