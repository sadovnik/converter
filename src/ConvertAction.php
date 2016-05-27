<?php

namespace Converter\ConvertAction;

use Converter\Result;
use function Converter\convert;
use function Converter\Utils\getExtension;
use function Converter\Utils\readFile;
use function Converter\Utils\writeFile;

/**
 * @param array $args arguments passed from cli
 */
function validateArgs($args)
{
    if (count($args) !== 2) {
        if (count($args) == 1) {
            $error = 'Not enouth arguments.';
        } elseif (count($args) > 2) {
            $error = 'Too many arguments.';
        }
        $usageExample = <<<EOL
    Usage example:
          convert from.yml to.json
EOL;
        $message = $error . PHP_EOL . $usageExample;
        return Result\error($message);
    }
    return Result\success();
}

/**
 * Validates the paths provided by user
 * @param string $input path to the input file
 * @param string $output path to the output file
 */
function validatePaths($inputPath, $outputPath)
{
    // if (!file_exists($inputPath)) {
    //     throw new \Exception("File not found: $inputPath");
    // }

    foreach ([$inputPath, $outputPath] as $path) {
        $ext = getExtension($path);
        if (!in_array($ext, ['json', 'yml', 'yaml', 'ini'])) {
            throw new \Exception("Unknown extension: «{$ext}». Allowed extensions are json, yaml (yml) and ini");
        }
    }

    if (getExtension($inputPath) === getExtension($outputPath)) {
        throw new \Exception('Extensions shouldn\'t match!');
    }
}

/**
 * Convert action
 * @param array $args arguments passed from cli
 * @return callable result
 */
function run($args)
{
    $validationResult = validateArgs($args);

    if(Result\isError($validationResult)) {
        return $validationResult;
    }

    list($inputPath, $outputPath) = $args;

    $content = readFile($inputPath);
    if(Result\isError($content)) {
        return $content;
    }

    $convertedContent = convert(
        Result\getValue($content),
        getExtension($inputPath),
        getExtension($outputPath)
    );
    if(Result\isError($convertedContent)) {
        return $convertedContent;
    }

    return writeFile($outputPath, Result\getValue($convertedContent));
}
