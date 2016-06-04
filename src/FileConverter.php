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
    $sourceContent = File\read($source);

    if (Result\isFail($sourceContent)) {
        return $sourceContent;
    }

    $convertedContent = convert(
        Result\valueOf($sourceContent),
        getExtension($source),
        getExtension($destination)
    );

    if (Result\isFail($convertedContent)) {
        return $convertedContent;
    }

    return File\write($destination, Result\valueOf($convertedContent));
}
