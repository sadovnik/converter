<?php

namespace Converter\FileConverter;

use Converter\Result;
use function Converter\convert;
use function Converter\Utils\getExtension;
use function Converter\File\read;
use function Converter\File\write;

/**
 * Converts source file and writes it the destination path
 * @param string $source
 * @param string $destination
 * @return callable
 */
function convert($source, $destination)
{
    $content = read($source);
    if (Result\isError($content)) {
        return $content;
    }

    $convertedContent = convert(
        Result\getValue($content),
        getExtension($source),
        getExtension($destination)
    );
    if (Result\isError($convertedContent)) {
        return $convertedContent;
    }

    return write($destination, Result\getValue($convertedContent));
}
