<?php
/**
 *   +----------------------------------------------------------------------
 *   | PROJECT:   [ KaadonHelper ]
 *   +----------------------------------------------------------------------
 *   | 官方网站:   [ https://developer.kaadon.com ]
 *   +----------------------------------------------------------------------
 *   | Author:    [ kaadon.com <kaadon.com@gmail.com>]
 *   +----------------------------------------------------------------------
 *   | Tool:      [ PhpStorm ]
 *   +----------------------------------------------------------------------
 *   | Date:      [ 2024/11/13 ]
 *   +----------------------------------------------------------------------
 *   | 版权所有    [ 2020~2024 kaadon.com ]
 *   +----------------------------------------------------------------------
 **/

namespace Kaadon\Helper;


/**
 * Title
 * Class ImageHelper
 */
class GdImageHelper
{
    /**
     * @var array|string[]
     */
    public static $extensions = [
        'png', 'gif', 'jpeg', 'jpg', 'bmp', 'webp', 'xbm'
    ];

    /**
     * @var resource|false
     */
    protected $image;

    /**
     * @param string $imagePath
     * @param string|null $extension
     * @throws \Exception
     */
    public function __construct(string $imagePath, string $extension = null)
    {
        // 根据 $imagePath 的后缀名来判断图片类型
        $ext = $extension ?? strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
        if (empty($ext)) {
            throw new HelperException('unrecognized image type');
        }
        $this->image = $this->createImageFromPath($imagePath);
        if ($this->image === false) {
            throw new HelperException('Unsupported image type: ' . $ext);
        }
    }

    /**
     * @param string $imagePath
     * @return resource|false
     */
    private function createImageFromPath(string $imagePath)
    {
        $imageInfo = getimagesize($imagePath);
        if (!$imageInfo) {
            return false;
        }
        switch ($imageInfo[2]) {
            case IMAGETYPE_GIF:
                return imagecreatefromgif($imagePath);
            case IMAGETYPE_JPEG:
                return imagecreatefromjpeg($imagePath);
            case IMAGETYPE_PNG:
                return imagecreatefrompng($imagePath);
            case IMAGETYPE_BMP:
                return imagecreatefrombmp($imagePath);
            case IMAGETYPE_WEBP:
                return imagecreatefromwebp($imagePath);
            case IMAGETYPE_XBM:
                return imagecreatefromxbm($imagePath);
            default:
                return false;
        }
    }

    /**
     * @param string $suffix
     * @return bool
     */
    public static function isSupportSuffix($suffix): bool
    {
        return in_array($suffix, self::$extensions);
    }

    /**
     * @param int $width
     * @param int $height
     * @return $this
     */
    public function resize(int $width, int $height)
    {
        $newImage = imagecreatetruecolor($width, $height);
        imagecopyresampled($newImage, $this->image, 0, 0, 0, 0, $width, $height, imagesx($this->image), imagesy($this->image));
        imagedestroy($this->image);
        $this->image = $newImage;
        return $this;
    }

    /**
     * @param string $targetPath
     * @param string $format
     * @return string
     * @throws \Exception
     */
    public function convertTo(string $targetPath, string $format): string
    {
        if (!imageistruecolor($this->image)) {
            imagepalettetotruecolor($this->image);
        }
        switch (strtolower($format)) {
            case 'png':
                imagepng($this->image, $targetPath);
                break;
            case 'gif':
                imagegif($this->image, $targetPath);
                break;
            case 'jpeg':
            case 'jpg':
                imagejpeg($this->image, $targetPath);
                break;
            case 'bmp':
                imagebmp($this->image, $targetPath);
                break;
            case 'webp':
                imagewebp($this->image, $targetPath);
                break;
            default:
                throw new HelperException('Unsupported target format: ' . $format);
        }
        imagedestroy($this->image);
        return $targetPath;
    }
}