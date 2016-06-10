<?php

namespace Converter\FileConverter;

use function Converter\convert;
use function Converter\Utils\getExtension;
use Converter\File;
use Result;

/**
 * Converts source file and writes it the destination path
 * @param string $source
 * @param string $destination
 * @return callable
 */
function convert($source, $destination)
{
    $read = function($input) use ($source) {
        return File\read($source);
    };

    $convert = function($input) use ($source, $destination) {
        return convert(
            $input,
            getExtension($source),
            getExtension($destination)
        );
    };

    $write = function($input) use ($destination) {
        return File\write($destination, $input);
    };

    $pipeline = Result\pipeline($read, $convert, $write);

    return Result\getOrThrow($pipeline);
}
