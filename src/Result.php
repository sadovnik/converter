<?php

namespace Converter\Result;

/**
 * Creates success result object
 * @param mixed $value
 * @return callable
 */
function success($value = null)
{
    return function ($method) use ($value) {
        switch ($method) {
            case 'getType':
                return 'success';

            case 'getValue':
                return $value;
        }
    };
}

/**
 * Creates error result object
 * @param string $message
 * @return callable
 */
function error($message = 'Unknown error')
{
    return function ($method) use ($message) {
        switch ($method) {
            case 'getType':
                return 'error';

            case 'getMessage':
                return $message;
        }
    };
}

/**
 * @param callable $callback
 * @param string $message
 * @return callable result
 */
function tryCatch(callable $callback, $message = '')
{
    try {
        return success($callback());
    } catch (\Exception $e) {
        return error($message . $e->getMessage());
    }
}

/**
 * @param callable $result
 * @return string
 */
function getType(callable $result)
{
    return $result('getType');
}

/**
 * @param callable $result
 * @return mixed
 */
function getValue(callable $result)
{
    return $result('getValue');
}

/**
 * @param callable $result
 * @return string
 */
function getMessage(callable $result)
{
    return $result('getMessage');
}

/**
 * @param callable $result
 * @return boolean
 */
function isSuccess(callable $result)
{
    return $result('getType') === 'success';
}

/**
 * @param callable $result
 * @return boolean
 */
function isError(callable $result)
{
    return $result('getType') === 'error';
}
