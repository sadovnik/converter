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
    protected function setThingsUp()
    {
        $this->rootDirectory = vfsStream::setup('root', 0777);
        $this->baseFixturePath = __DIR__ . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR;
        $this->baseVfsPath = vfsStream::url($this->rootDirectory->path() . DIRECTORY_SEPARATOR);
    }

    /**
     * @dataProvider provider
     */
    public function testRun(
        $args,
        $isSuccess,
        $countainsOutput,
        $expecetedGeneratesFile
    ) {
        $result = runConvertAction($args);
        $this->assertEquals($isSuccess, Result\isSuccess($result));
        if (Result\isError($result)) {
            $this->assertTrue(strpos(Result\getMessage($result), $countainsOutput) !== false);
        } elseif (count($args) === 2) {
            $fileName = pathinfo($args[1])['basename'];
            $this->assertEquals($expecetedGeneratesFile, $this->rootDirectory->hasChild($fileName));
        }
    }

    public function provider()
    {
        /* @see http://theaveragedev.com/phpunit-setup-loves-test-methods/ */
        $this->setThingsUp();
        $fp = $this->baseFixturePath;
        $vp = $this->baseVfsPath;
        $nonAccessibleFile = vfsStream::newFile($vp . 'test.json', 0000);

        return [
            // args, isSuccess, output, generates file

            // success
            [ [ $fp . 'fixture_1.json', $vp . 'result_1.yml' ], true, null, true ],
            [ [ $fp . 'fixture_1.json', $vp . 'result_2.yaml' ], true, null, true ],
            [ [ $fp . 'fixture_1.json', $vp . 'result_3.ini' ], true, null, true ],
            [ [ $fp . 'fixture_1.json', $vp . 'result_4.json' ], true, null, true ],

            // error
            [ [ $fp . 'nonexisting.json', $vp . 'test.yml' ], false, 'File not found', false ],
            [ [ $fp . '', $vp . 'test.yml' ], false, 'is not a file', false ],
            [ [ $fp . '', $vp . 'test.yml' ], false, 'Permission denied', false ],
            // [ [ $nonAccessibleFile, $vp . 'test.yml' ], false, 'Permission denied', false ],
        ];
    }
}
