<?php

/**
 * Created by PhpStorm.
 * User: max
 * Date: 02.11.15
 * Time: 20:16
 */
namespace mxkh\VideoThumbnail;

use mxkh\url\UrlFinder;
use mxkh\VideoThumbnail\provider\VideoProvider;
use Yii;
use yii\base\Component;

/**
 * Class VideoThumbnail
 * @package mxkh\VideoThumbnail
 * @property VideoProvider $videoProvider
 */
class VideoThumbnail extends Component
{
    /**
     * @var VideoProvider
     */
    public $videoProvider;

    public function init()
    {
        parent::init();

        $this->videoProvider = new VideoProvider();
    }

    public function getThumbnail($url)
    {
        return $this->videoProvider->getVideoThumbnail($url);
    }
}