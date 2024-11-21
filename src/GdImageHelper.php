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
    public static array $extensions = [
        'png','gif','jpeg','jpg','bmp','webp','xbm','xpm'
    ];

    public static function isSupportSuffix($suffix): bool
    {
        return in_array($suffix,self::$extensions);
    }
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
        $this->image = match ($ext) {
            'png' => imagecreatefrompng($imagePath),
            'gif' => imagecreatefromgif($imagePath),
            'jpeg', 'jpg' => imagecreatefromjpeg($imagePath),
            'bmp' => imagecreatefrombmp($imagePath),
            'webp' => imagecreatefromwebp($imagePath),
            'xbm' => imagecreatefromxbm($imagePath),
            'xpm' => imagecreatefromxpm($imagePath),
            default => throw new HelperException('Unsupported image type: ' . $ext),
        };
    }

    /**
     * @return int
     */
    private function getFileSize(): int
    {
        ob_start();
        imagejpeg($this->image);
        $content = ob_get_clean();
        return bcdiv((string) strlen($content), "1024", 4);
    }
    /**
     * @param int $width
     * @param int $height
     * @return $this
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