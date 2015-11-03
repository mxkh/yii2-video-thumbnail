<?php

/**
 * Created by PhpStorm.
 * User: max
 * Date: 02.11.15
 * Time: 20:30
 */
namespace mxkh\VideoThumbnail\provider;

/**
 * Class RuTubeProvider
 * @package mxkh\VideoThumbnail\provider
 */
class RuTubeProvider implements ProviderInterface
{
    public static function pattern()
    {
        return '%rutube%i';
    }

    public function requestThumbnail($id)
    {
        $api = 'http://rutube.ru/api/video/' . $id . '';
        $response = json_decode(file_get_contents($api));
        $thumbnails = $response->thumbnail_url;
        return $thumbnails;
    }

    public function sizes()
    {
        /**
         * RuTube has only one video thumbnail size
         */
    }
}