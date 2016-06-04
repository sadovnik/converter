<?php

namespace Converter\Tests;

abstract class BaseIsomorphicCoderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    public $format;

    private static $baseFixturePath = __DIR__ . DIRECTORY_SEPARATOR . 'fixtures';

    /**
     * @dataProvider provider
     */
    public function test($input)
    {
        $this->assertEquals($input, $this->encode($this->decode($input)));
    }

    abstract public function decode($string);
    abstract public function encode($array);

    /**
     * @return array
     */
    public function provider()
    {
        return array_map(
            function ($fixture) {
                $content = file_get_contents(self::$baseFixturePath . DIRECTORY_SEPARATOR . $fixture);
                return [ $content ];
            },
            array_filter(
                scandir(self::$baseFixturePath),
                function ($path) {
                    return pathinfo($path, PATHINFO_EXTENSION) === $this->format
                        && strpos(pathinfo($path, PATHINFO_FILENAME), 'bad') === false;
                }
            )
        );
    }
}
