<?php

namespace Converter;

use Converter\Result;
use Converter\Coders\Ini;
use Converter\Coders\Json;
use Converter\Coders\Yaml;
use function Converter\Utils\getExtension;

/**
 * @return callable error result with unknown extention message
 */
function throwUnknownExtention($ext)
{
    return Result\error("Unknown extension: «{$ext}». Allowed extensions are json, yaml (yml) and ini");
}

/**
 * @param string $input data to convert
 * @param string $from format
 * @param string $to format
 * @return string result
 */
function convert($input, $from, $to)
{
    $decodingResult = decode($input, $from);
    if (Result\isError($decodingResult)) {
        return $decodingResult;
    }
    return encode(Result\getValue($decodingResult), $to);
}

/**
 * @param string $ext extension
 * @return callable encoder
 */
function encode($array, $ext)
{
    switch ($ext) {
        case 'ini':
            return Ini\encode($array);

        case 'yaml':
        case 'yml':
            return Yaml\encode($array);

        case 'json':
            return Json\encode($array);
        default:
            return throwUnknownExtention($ext);
    }
}

/**
* @param string $ext extension
* @return callable decoder
*/
function decode($content, $ext)
{
    switch ($ext) {
        case 'ini':
            return Ini\decode($content);

        case 'yaml':
        case 'yml':
            return Yaml\decode($content);

        case 'json':
            return Json\decode($content);

        default:
            return throwUnknownExtention($ext);
    }
}
