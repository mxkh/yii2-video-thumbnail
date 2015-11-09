<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 03.11.15
 * Time: 00:19
 */

namespace mxkh\VideoThumbnail\provider;


use mxkh\url\UrlFinder;

class VideoProvider
{
    const PROVIDER_YOUTUBE = 'youtube';
    const PROVIDER_VIMEO = 'vimeo';
    const PROVIDER_RUTUBE = 'rutube';

    public $providerId;
    public $provider;
    public $videoId;

    /**
     * @param $url
     * @return null|string
     */
    public function identifyProvider($url)
    {
        foreach ($this->providers() as $id => $provider) {
            $finder = new UrlFinder($id);
            $video = $finder->{$id}->subject($url)->one();
            if (!empty($video['url'])) {
                return [
                    'providerId' => $id,
                    'provider' => $provider,
                    'videoId' => $video['id'],
                ];
            }
        }

        return null;
    }

    /**
     * Returns provider classes
     * @return array
     */
    public function providers()
    {
        return [
            self::PROVIDER_YOUTUBE => YoutubeProvider::class,
            self::PROVIDER_VIMEO => VimeoProvider::class,
            self::PROVIDER_RUTUBE => RuTubeProvider::class,
        ];
    }

    /**
     * @param $providerId
     * @return YoutubeProvider|VimeoProvider|RuTubeProvider
     */
    public function getProviderInstance($providerId)
    {
        $provider = $this->providers()[$providerId];
        return new $provider;
    }

    /**
     * @param YoutubeProvider $provider
     * @return string
     */
    public function getProviderPattern($provider)
    {
        return $provider::pattern();
    }

    public function getVideoThumbnail($url)
    {
        // Get video provider id
        $identity = $this->identifyProvider($url);

        if (!$identity) {
            return null;
        }
        // Get provider instance
        $this->provider = $this->getProviderInstance($identity['providerId']);

        return $this->provider->requestThumbnail($identity['videoId']);
    }
}