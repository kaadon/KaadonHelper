<?php

namespace Kaadon\Test;

use Kaadon\Helper\GdImageHelper;
use Kaadon\Helper\HelperException;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class GdImageHelperTest extends TestCase
{
    /**
     * @return void
     * @throws \Kaadon\Helper\HelperException
     */
    public function testConvertTo()
    {
        $image = new GdImageHelper(__DIR__ . '/test.png');
        $image->convertTo(__DIR__ . '/test.webp','webp');
        $this->assertFileExists(__DIR__ . '/test.webp');
    }

}
