<?php

namespace Converter;

use function Converter\ConvertAction\run as runConvertAction;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\visitor\vfsStreamStructureVisitor;

class ConvertActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var vfsStreamDirectory
     */
    protected $rootDirectory;

    /**
     * @var string
     */
    protected $baseFixturePath;

    /**
     * @var string
     */
    protected $baseVfsPath;

    /**
     * set up test environmemt
     */
    protected function setUp()
    {
        $this->rootDirectory = vfsStream::setup('root', 0777);
        $this->baseFixturePath = __DIR__ . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR;
        $this->baseVfsPath = vfsStream::url($this->rootDirectory->path() . DIRECTORY_SEPARATOR);
    }

    public function testRun()
    {
        $fp = $this->baseFixturePath;
        $vp = $this->baseVfsPath;

        $providerList = [
            /**
             * Order of data:
             * args, isSuccess, output, generates file
             */

            /**
             * Success cases:
             */
            [ [ $fp . 'fixture_1.json', $vp . 'result_1.yml' ], true, null, true ],
            [ [ $fp . 'fixture_1.json', $vp . 'result_2.yaml' ], true, null, true ],
            [ [ $fp . 'fixture_1.json', $vp . 'result_3.ini' ], true, null, true ],
            [ [ $fp . 'fixture_1.json', $vp . 'result_4.json' ], true, null, true ],

            /**
             * Error cases
             */
            // File not found
            [ [ $fp . 'nonexisting.json', $vp . 'test.yml' ], false, 'File not found', false ],

            // Not a file
            [ [ $fp . '', $vp . 'test.yml' ], false, 'is not a file', false ],

            // Corrupted input file
            [ [ $fp . 'bad.json', $vp . 'test.yml' ], false, 'Couldn\'t decode json', false ],

            // Wrong usage
            [ [ ], false, 'Not enouth arguments', false ],
            [ [ 'foo' ], false, 'Not enouth arguments', false ],
            [ [ 'foo', 'bar', 'baz'], false, 'Too many arguments', false ],

            // Unknown format
            [ [ $fp . 'unknown.format', $vp . 'test.ini' ], false, 'Unknown extension', false ],
            [ [ $fp . 'fixture_1.json', $vp . 'unknown.format' ], false, 'Unknown extension', false ],

            // Permission denied
            // [ [ $file->path(), $vp . 'test.yml' ], false, 'Permission denied', false ],
        ];

        foreach ($providerList as $providerItem) {
            list($args, $isSuccess, $countainsOutput, $expecetedGeneratesFile) = $providerItem;
            $result = runConvertAction($args);
            $this->assertEquals($isSuccess, Result\isSuccess($result));
            if (Result\isError($result)) {
                $this->assertTrue(strpos(Result\getMessage($result), $countainsOutput) !== false);
            } elseif (count($args) === 2) {
                $fileName = pathinfo($args[1])['basename'];
                $this->assertEquals($expecetedGeneratesFile, $this->rootDirectory->hasChild($fileName));
            }
        }
    }
}
