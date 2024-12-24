<?php
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
     * @var Video|Audio
     */
    protected $video;

    /**
     * @param string $videoPath
     * @throws \Kaadon\Helper\HelperException
     */
    public function __construct(string $videoPath)
    {
        $ffmpeg = FFMpeg::create();
        $this->video = $ffmpeg->open($videoPath);
        // 判断是视频文件
        if (!$this->video->getStreams()->videos()->first()) {
            throw new HelperException('不是视频文件');
        }
    }

    /**
     * @param int $width
     * @param int $height
     * @return $this
     * @throws \Kaadon\Helper\HelperException
     */
    public function synchronize(int $width, int $height): FFMpegVideoHelper
    {
        try {
            // 逻辑代码
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
    public function convertTo($path, $format = 'mp4')
    {
        $path = preg_replace('/\.' . $format . '$/', '', $path);
        try {
            // 逻辑代码
            $filename = "$path.$format";
            switch ($format) {
                case 'mp4':
                    $this->video->save(new X264(), $filename);
                    break;
                case 'webm':
                    $this->video->save(new WebM(), $filename);
                    break;
                case 'ogg':
                    $this->video->save(new Ogg(), $filename);
                    break;
                case 'wmv':
                    $this->video->save(new WMV(), $filename);
                    break;
                case 'wmv3':
                    $this->video->save(new WMV3(), $filename);
                    break;
                default:
                    throw new HelperException('Unsupported target format: ' . $format);
            }
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
    public function toThumbnail($thumbnailPath): string
    {
        try {
            // 逻辑代码
            $frame = $this->video->frame(TimeCode::fromSeconds(1));
            $frame->save($thumbnailPath);
        } catch (Exception $exception) {
            throw new HelperException($exception->getMessage());
        }
        return $thumbnailPath;
    }
}