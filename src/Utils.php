<?php

namespace Converter\Utils;

use Converter\Result;

/**
 * @param string $path path to file
 * @return string normalized extension extracted from path
 */
function getExtension($path)
{
    return strtolower(pathinfo($path, PATHINFO_EXTENSION));
}
