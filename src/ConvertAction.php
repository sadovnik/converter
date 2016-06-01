<?php

namespace Converter\ConvertAction;

use Converter\Result;
use function Converter\convert;
use function Converter\Utils\getExtension;
use function Converter\File\read;
use function Converter\File\write;

/**
 * @param array $args arguments passed from cli
 */
function validateArgs($args)
{
    $argsCount = count($args);

    if ($argsCount === 2) {
        return Result\success();
    }

    $errorMessage = '';
    if ($argsCount < 2) {
        $errorMessage = 'Not enouth arguments.';
    } elseif ($argsCount > 2) {
        $errorMessage = 'Too many arguments.';
    }

    $usageExample = <<<EOL
Usage example:
      convert from.yml to.json
EOL;

    return Result\error($errorMessage . PHP_EOL . $usageExample);
}

/**
 * Convert action
 * @param array $args arguments passed from cli
 * @return callable result
 */
function run($args)
{
    $validationResult = validateArgs($args);

    if (Result\isError($validationResult)) {
        return $validationResult;
    }

    list($inputPath, $outputPath) = $args;

    $content = read($inputPath);
    if (Result\isError($content)) {
        return $content;
    }

    $convertedContent = convert(
        Result\getValue($content),
        getExtension($inputPath),
        getExtension($outputPath)
    );
    if (Result\isError($convertedContent)) {
        return $convertedContent;
    }

    return write($outputPath, Result\getValue($convertedContent));
}
