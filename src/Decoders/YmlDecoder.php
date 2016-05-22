<?php

namespace Converter\Decoders;

/**
 * @return callable
 */
function YmlDecoder()
{
    $decode = function ($yml) {
        extension_loaded('yaml') or exit('Yaml extension is required 🐦');
        return yaml_parse($yml);
    };
    return $decode;
}
