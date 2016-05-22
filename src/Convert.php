<?php

namespace Converter;

use function Converter\Decoders\IniDecoder;
use function Converter\Decoders\JsonDecoder;
use function Converter\Decoders\YmlDecoder;
use function Converter\Encoders\IniEncoder;
use function Converter\Encoders\JsonEncoder;
use function Converter\Encoders\YmlEncoder;

/**
 * Does the thing
 * @param string $input path to the input file
 * @param string $output path to the output file
 * @return integer status
 */
function Converter()
{
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
    $validate = function ($input, $output) use ($getExtension) {
        // Validation
        if (!file_exists($input)) {
            echo "Error! File not found: $input" . PHP_EOL;
            return false;
        }

        array_map(function ($path) {
            $ext = strtolower(pathinfo($path)['extension']);
            if (!in_array($ext, ['json', 'yml', 'ini'])) {
                echo "Error! Unknown extension: $ext" . PHP_EOL;
                echo 'Allowed extensions are json, yml and ini' . PHP_EOL;
                return false;
            }
        }, func_get_args());

        if ($getExtension($input) === $getExtension($output)) {
            echo 'Error! Extensions shouldn\'t match!' . PHP_EOL;
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
    $convert = function ($input, $output) use ($getEncoder, $getDecoder, $getExtension) {
        $inputFileContent = file_get_contents($input);
        $decoder = $getDecoder($getExtension($input));
        $arrayRepresentation = $decoder($inputFileContent);
        $encoder = $getEncoder($getExtension($output));
        $outputRepresentation = $encoder($arrayRepresentation);
        file_put_contents($output, $outputRepresentation);
    };

    $converter = function ($input, $output) use ($validate, $convert) {
        if (!$validate($input, $output)) {
            return ERROR_EXIT_CODE;
        }
        $convert($input, $output);
        echo 'Done!' . PHP_EOL;
        return OK_EXIT_CODE;
    };

    return $converter;
}
