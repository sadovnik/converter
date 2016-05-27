<?php

namespace Converter\Utils;

use Converter\Result;

/**
 * @param string $path path to file
 * @return string normalized extension extracted from path
 */
function getExtension($path)
{
    return strtolower(pathinfo($path)['extension']);
}

/**
 * Reads the config
 * @param string $path
 * @return callable result
 */
function readFile($path)
{
    if (!file_exists($path)) {
        return Result\error("File not found: $path");
    }

    if (!is_file($path)) {
        return Result\error("$path is not a file");
    }

    if (!is_readable($path)) {
        return Result\error('Permission denied');
    }

    $result = file_get_contents($path);

    return $result !== false ? Result\success($result) : Result\error("Couldn't read $path");
}

/**
 * Writes the config
 * @param string $path
 * @param string $content
 * @return callable result
 */
function writeFile($path, $content)
{
    if (!is_writable(dirname($path))) {
        return Result\error("$path is not witable");
    }

    $result = file_put_contents($path, $content);

    return $result !== false ? Result\success($result) : Result\error("Couldn't write to $path");
}

/**
 * @return boolean whether is closure or not
 */
function isClosure($value)
{
    return is_object($value) && ($value instanceof Closure);
}
