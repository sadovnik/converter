<?php

namespace Converter\Encoders;

/**
 * @return callable
 */
function YmlEncoder()
{
    $encode = function ($array) {
        extension_loaded('yaml') or exit('Yaml extension is required 🐦');
        return yaml_emit($array);
    };

    return $encode;
}
