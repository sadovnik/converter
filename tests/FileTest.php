<?php

namespace Converter\Tests;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamFile;
use org\bovigo\vfs\vfsStreamDirectory;
use Converter\File;
use Result;

class FileTest extends \PHPUnit_Framework_TestCase
{
    protected $root;

    public function setUp()
    {
        $this->root = vfsStream::setUp();
    }

    public function testReadNormal()
    {
        $fileContent = '{"hello": "world"}';
        $file = (new vfsStreamFile('some.json'))->withContent($fileContent);
        $this->root->addChild($file);
        $result = File\read($file->url());
        $this->assertTrue(Result\isOk($result));
        $this->assertEquals($fileContent, Result\valueOf($result));
    }

    public function testReadNotFoundError()
    {
        $result = File\read($this->root->url() . '/non-existing.file');
        $this->assertTrue(Result\isFail($result));
        $this->assertContains('File not found', Result\valueOf($result));
    }

    public function testReadNotAFile()
    {
        $result = File\read($this->root->url());
        $this->assertTrue(Result\isFail($result));
        $this->assertContains('is not a file', Result\valueOf($result));
    }

    public function testReadPermissionDeniedError()
    {
        $file = new vfsStreamFile('some.json', 0000);
        $this->root->addChild($file);
        $result = File\read($file->url());
        $this->assertTrue(Result\isFail($result));
        $this->assertContains('Permission denied', Result\valueOf($result));
    }

    public function testWriteNormal()
    {
        $fileContent = '{"hello": "world"}';
        $url = $this->root->url() . '/result.json';
        $result = File\write($url, $fileContent);
        $this->assertTrue(Result\isOk($result));
        $this->assertEquals($fileContent, file_get_contents($url));
    }

    public function testWriteNotWritableError()
    {
        $notReadableDirectory = new vfsStreamDirectory('super-puper-secret-docs', 000);
        $this->root->addChild($notReadableDirectory);
        $url = $notReadableDirectory->url() . '/invoice.yml';
        $result = File\write($url, 'foo bar');
        $this->assertTrue(Result\isFail($result));
        $this->assertContains('is not writable', Result\valueOf($result));
    }
}
