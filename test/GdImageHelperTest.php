<?php

namespace Kaadon\Test;

use Kaadon\Helper\GdImageHelper;
use PHPUnit\Framework\TestCase;

/**
 *
 */
class GdImageHelperTest extends TestCase
{
    /**
     * @return void
     * @throws \Exception
     */
    public function testConvertTo()
    {
        $image = new GdImageHelper(__DIR__ . '/test.jpg');
        $image->convertTo(__DIR__ . '/test.webp','webp');
        $this->assertFileExists(__DIR__ . '/test.webp');
    }

}
