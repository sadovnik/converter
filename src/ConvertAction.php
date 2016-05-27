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
