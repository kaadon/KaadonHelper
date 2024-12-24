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

use GdImage;

/**
 * Title
 * Class ImageHelper
 */
class GdImageHelper
{

    /**
     * @var array|string[]
     */
    public static array $extensions = [
        'png','gif','jpeg','jpg','bmp','webp','xbm'
    ];
    /**
     * @var \GdImage|false|resource
     */
    protected GdImage|false $image;

    /**
     * @param string $imagePath
     * @param string|null $extension
     * @throws \Kaadon\Helper\HelperException
     */
    public function __construct(string $imagePath,string $extension = null)
    {
        // 根据 $imagePath 的后缀名来判断图片类型
        $ext = $extension??strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
        if (empty($ext)) throw new HelperException('unrecognized image type');
        $this->image = $this->createImageFromPath($imagePath);
        if ($this->image === false) {
            $this->write_log('Unsupported image type: ' . $ext);
            throw new HelperException('Unsupported image type: ' . $ext);
        }
    }
    private function write_log($msg): void
    {
        $log_file = 'log.txt';
        $msg = date('Y-m-d H:i:s') . ':' . $msg . PHP_EOL;
        file_put_contents($log_file, $msg, FILE_APPEND);
    }

    /**
     * @param string $imagePath
     * @return false|\GdImage|resource
     */
    private function createImageFromPath(string $imagePath)
    {
        $imageInfo = getimagesize($imagePath);
        if (!$imageInfo) {
            return false;
        }
        return match ($imageInfo[2]) {
            IMAGETYPE_GIF => imagecreatefromgif($imagePath),
            IMAGETYPE_JPEG => imagecreatefromjpeg($imagePath),
            IMAGETYPE_PNG => imagecreatefrompng($imagePath),
            IMAGETYPE_BMP => imagecreatefrombmp($imagePath),
            IMAGETYPE_WEBP => imagecreatefromwebp($imagePath),
            IMAGETYPE_XBM => imagecreatefromxbm($imagePath),
            default => false,
        };
    }
    /**
     * @param $suffix
     * @return bool
     * @noinspection PhpUnused
     */
    public static function isSupportSuffix($suffix): bool
    {
        return in_array($suffix,self::$extensions);
    }
    /**
     * @param int $width
     * @param int $height
     * @return $this
     * @noinspection PhpUnused
     */
    public function resize(int $width, int $height): self
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
     * @throws \Kaadon\Helper\HelperException
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