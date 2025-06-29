<?php

namespace Kaadon\Helper;

use Imagick;
use ImagickException;

/**
 * Title
 * Class ImageHelper
 */
class ImagickImageHelper
{
    /**
     * @var Imagick
     */
    protected $image;

    /**
     * @param string $imagePath
     * @throws \Exception
     */
    public function __construct(string $imagePath)
    {
        try {
            $this->image = new Imagick($imagePath);
        } catch (ImagickException $e) {
            throw new HelperException('Failed to load image: ' . $e->getMessage());
        }
    }

    /**
     * @param int $width
     * @param int $height
     * @return $this
     * @throws \Exception
     */
    public function resize(int $width, int $height): ImagickImageHelper
    {
        try {
            $this->image->resizeImage($width, $height, Imagick::FILTER_LANCZOS, 1);
        } catch (ImagickException $e) {
            throw new HelperException('Failed to resize image: ' . $e->getMessage());
        }
        return $this;
    }

    /**
     * @param string $targetPath
     * @param string $format
     * @return string
     * @throws \Exception
     */
    public function convertTo(string $targetPath, string $format, ?int $quality = null): string
    {
        try {
            $this->image->setImageFormat($format);
            if ($quality) $this->image->setImageCompressionQuality($quality);
            $this->image->writeImage($targetPath);
        } catch (ImagickException $e) {
            throw new HelperException('Failed to convert image: ' . $e->getMessage());
        }
        return $targetPath;
    }

    /**
     * @param string $suffix
     * @return bool
     */
    public static function isSupportSuffix(string $suffix): bool
    {
        $supportedFormats = Imagick::queryFormats();
        return in_array(strtoupper($suffix), $supportedFormats);
    }

    /**
     * Destructor to clean up resources.
     */
    public function __destruct()
    {
        if ($this->image instanceof Imagick) {
            $this->image->clear();
            $this->image->destroy();
        }
    }
}