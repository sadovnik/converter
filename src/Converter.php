<?php

namespace Converter;

use function Converter\Decoders\IniDecoder;
use function Converter\Decoders\JsonDecoder;
use function Converter\Decoders\YmlDecoder;
use function Converter\Encoders\IniEncoder;
use function Converter\Encoders\JsonEncoder;
use function Converter\Encoders\YmlEncoder;

/**
 * @param string $input path to the input file
 * @param string $output path to the output file
 * @return integer status
 */
function createConverter($input, $output)
{
    /**
     * @var array
     */
    $errors = [];

    /**
     * @param string $path path to file
     * @return string normalized extension extracted from path
     */
    $getExtension = function ($path) {
        return strtolower(pathinfo($path)['extension']);
    };

    /**
     * Validates the paths provided by user
     * @param string $input path to the input file
     * @param string $output path to the output file
     * @return boolean true if ok
     */
    $validate = function () use ($getExtension, &$errors, $input, $output) {
        $errors = [];

        // Validation
        if (!file_exists($input)) {
            $error = "Error! File not found: $input";
            array_push($errors, $error);
            return false;
        }

        foreach ([$input, $output] as $path) {
            $ext = $getExtension($path);
            if (!in_array($ext, ['json', 'yml', 'ini'])) {
                $error = "Unknown extension: «{$ext}». Allowed extensions are json, yml and ini";
                array_push($errors, $error);
                return false;
            }
        }

        if ($getExtension($input) === $getExtension($output)) {
            $error = 'Error! Extensions shouldn\'t match!';
            array_push($errors, $error);
            return false;
        }

        return true;
    };

    /**
     * @param string $ext extension
     * @return callable encoder
     */
    $getEncoder = function ($ext) {
        switch ($ext) {
            case 'ini':
                return IniEncoder();
            case 'yml':
                return YmlEncoder();
            case 'json':
                return JsonEncoder();
        }
    };

    /**
    * @param string $ext extension
    * @return callable decoder
    */
    $getDecoder = function ($ext) {
        switch ($ext) {
            case 'ini':
                return IniDecoder();
            case 'yml':
                return YmlDecoder();
            case 'json':
                return JsonDecoder();
        }
    };

    /**
     * @param string $input path to the input file
     * @param string $output path to the output file
     * @return integer exit code
     */
    $convertFile = function () use ($getEncoder, $getDecoder, $getExtension, $input, $output) {
        $inputFileContent = file_get_contents($input);
        $decoder = $getDecoder($getExtension($input));
        $arrayRepresentation = $decoder($inputFileContent);
        $encoder = $getEncoder($getExtension($output));
        $outputRepresentation = $encoder($arrayRepresentation);
        file_put_contents($output, $outputRepresentation);
    };

    /**
     * Makes validation and converts
     */
    $convert = function () use ($validate, $convertFile, $input, $output) {
        if (!$validate()) {
            return false;
        }

        $convertFile();

        return true;
    };

    $converter = function ($action, ...$args) use ($convert, &$errors) {
        switch ($action) {
            case 'convert':
                return $convert();

            case 'getErrors':
                return $errors;

            default:
                die("Whoops! Looks like there's no «{$action}» method.");
        }
    };

    return $converter;
}

/**
 * @return boolean true if success
 */
function convert(callable $converter)
{
    return $converter('convert');
}

/**
 * @return array of string errors
 */
function getErrors(callable $converter)
{
    return $converter('getErrors');
}
