<?php

namespace Converter\Tests;

use Result;
use Converter\FileConverter;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\visitor\vfsStreamStructureVisitor;

class FileConverterTest extends \PHPUnit_Framework_TestCase
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

    public function testNormalFlow()
    {
        $source = $this->baseFixturePath . 'fixture_1.json';
        $dest = $this->baseVfsPath . 'result.yml';
        FileConverter\convert($source, $dest);
    }

    /**
     * @expectedException Exception
     */
    public function testFailFlow()
    {
        $source = $this->baseFixturePath . 'fixture_1.json';
        $dest = $this->baseVfsPath . 'result.unknown';
        FileConverter\convert($source, $dest);
    }
}
