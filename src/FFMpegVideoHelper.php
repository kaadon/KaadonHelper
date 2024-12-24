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

use Exception;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Coordinate\TimeCode;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\Ogg;
use FFMpeg\Format\Video\WebM;
use FFMpeg\Format\Video\WMV;
use FFMpeg\Format\Video\WMV3;
use FFMpeg\Format\Video\X264;
use FFMpeg\Media\Audio;
use FFMpeg\Media\Video;

/**
 * Title
 * Class VideoHelper
 */
class FFMpegVideoHelper
{
    /**
     * @var \FFMpeg\Media\Video|\FFMpeg\Media\Audio
     */
    protected Video|Audio $video;

    /**
     * @param string $videoPath
     * @throws \Kaadon\Helper\HelperException
     */
    public function __construct(string $videoPath)
    {
        $ffmpeg = FFMpeg::create();
        $this->video = $ffmpeg->open($videoPath);
        //判断是视频文件
        if (!$this->video->getStreams()->videos()->first()) {
            throw new HelperException('不是视频文件');
        }
    }

    /**
     * @param $width
     * @param $height
     * @return $this
     * @throws \Kaadon\Helper\HelperException
     */
    public function synchronize($width, $height): static
    {
        try {
            //逻辑代码
            $dimension = new Dimension($width, $height);
            $this->video->filters()
                ->resize($dimension)
                ->synchronize();
        } catch (Exception $exception) {
            throw new HelperException($exception->getMessage());
        }
        return $this;
    }

    /**
     * @param string $path
     * @param string $format
     * @return string
     * @throws \Kaadon\Helper\HelperException
     */
    public function convertTo(string $path, string $format = 'mp4'): string
    {
        $path = preg_replace('/\.'.$format.'$/', '', $path);
        try {
            //逻辑代码
            $filename =  "$path.$format";
            match ($format) {
                'mp4' => $this->video->save(new X264(), $filename),
                'webm' => $this->video->save(new WebM(), $filename),
                'ogg' => $this->video->save(new Ogg(), $filename),
                'wmv' => $this->video->save(new WMV(), $filename),
                'wmv3' => $this->video->save(new WMV3(), $filename),
                default => throw new HelperException('Unsupported target format: ' . $format),
            };
        } catch (Exception $exception) {
            throw new HelperException($exception->getMessage());
        }
        return $path;
    }

    /**
     * @param string $thumbnailPath
     * @return string
     * @throws \Kaadon\Helper\HelperException
     */
    public function toThumbnail(string $thumbnailPath): string
    {
        try {
            //逻辑代码
            $frame = $this->video->frame(TimeCode::fromSeconds(1));
            $frame->save($thumbnailPath);
        } catch (Exception $exception) {
            throw new HelperException($exception->getMessage());
        }
        return $thumbnailPath;
    }




}