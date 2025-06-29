<?php

namespace Kaadon\Test;

use Kaadon\Helper\ImagickImageHelper;
use PHPUnit\Framework\TestCase;

/**
 * Test class for ImagickImageHelper
 */
class ImagickImageHelperTest extends TestCase
{
    private $testImagePath;
    private $outputImagePath;

    protected function setUp(): void
    {
        $this->testImagePath = __DIR__ . '/test.png'; // Path to a test image
        $this->outputImagePath = __DIR__ . '/stest.png'; // Path for output image

        // Ensure the test image exists
        if (!file_exists($this->testImagePath)) {
            $this->markTestSkipped('Test image not found.');
        }
    }

    public function testResize(): void
    {
        $helper = new ImagickImageHelper($this->testImagePath);
        $helper->resize(100, 100);
        $this->assertNotNull($helper, 'Helper instance should not be null.');
    }

    public function testConvertTo(): void
    {
        $helper = new ImagickImageHelper($this->testImagePath);
        $resultPath = $helper->convertTo($this->outputImagePath, 'webp',96);
        $this->assertFileExists($resultPath, 'Converted image file should exist.');
    }

    public function testIsSupportSuffix(): void
    {
        $this->assertTrue(ImagickImageHelper::isSupportSuffix('jpg'), 'JPG should be supported.');
        $this->assertFalse(ImagickImageHelper::isSupportSuffix('unsupported'), 'Unsupported format should return false.');
    }

//    protected function tearDown(): void
//    {
//        // Clean up output image
//        if (file_exists($this->outputImagePath)) {
//            unlink($this->outputImagePath);
//        }
//    }
}