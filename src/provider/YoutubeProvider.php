<?php

/**
 * Created by PhpStorm.
 * User: max
 * Date: 02.11.15
 * Time: 20:29
 */
namespace mxkh\VideoThumbnail\provider;

/**
 * Class YoutubeProvider
 * @package mxkh\VideoThumbnail\provider
 */
class YoutubeProvider implements ProviderInterface
{
    public $apiKey = 'AIzaSyCNeZMtm4VLnRpdpIN_XS68h43uVkL8QvU';

    public static function pattern()
    {
        return '%youtube|youtu\.be%i';
    }

    /**
     * Returns thumbnail URL
     * @param $id
     * @return mixed
     */
    public function requestThumbnail($id)
    {
        $api = 'https://www.googleapis.com/youtube/v3/videos?key=' . $this->apiKey . '&part=snippet&id=' . $id . '';
        $response = json_decode(file_get_contents($api));
        $thumbnails = $response->items['0']->snippet->thumbnails;

        foreach ($this->sizes() as $size) {
            $thumbnail = isset($thumbnails->{$size}) ? $thumbnails->{$size} : null;
            if ($thumbnail) {
                $thumbnails = $thumbnail;
                break;
            }
        }

        return $thumbnails->url;
    }

    /**
     * Returns available video sizes
     * @return array
     */
    public function sizes()
    {
        return [
            'maxres',
            'standard',
            'high',
            'medium',
            'default',
        ];
    }
}