<?php

/**
 * Created by PhpStorm.
 * User: max
 * Date: 02.11.15
 * Time: 20:29
 */
namespace mxkh\VideoThumbnail\provider;

/**
 * Class VimeoProvider
 * @package mxkh\VideoThumbnail\provider
 */
class VimeoProvider implements ProviderInterface
{
    public static function pattern()
    {
        return '%vimeo%i';
    }

    public function requestThumbnail($id)
    {
        $api = 'http://vimeo.com/api/v2/video/' . $id . '.json';
        $response = json_decode(file_get_contents($api));
        $thumbnails = $response['0'];

        foreach ($this->sizes() as $size) {
            $thumbnail = isset($thumbnails->{$size}) ? $thumbnails->{$size} : null;
            if ($thumbnail) {
                $thumbnails = $thumbnail;
                break;
            }
        }


        return $thumbnails;
    }

    public function sizes()
    {
        return [
            'thumbnail_large',
            'thumbnail_medium',
            'thumbnail_small',
        ];
    }
}