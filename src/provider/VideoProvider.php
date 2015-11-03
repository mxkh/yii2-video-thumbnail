<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 03.11.15
 * Time: 00:19
 */

namespace mxkh\VideoThumbnail\provider;


use mxkh\url\UrlFinder;
use yii\base\InvalidParamException;

class VideoProvider
{
    const PROVIDER_YOUTUBE = 'youtube';
    const PROVIDER_VIMEO = 'vimeo';
    const PROVIDER_RUTUBE = 'rutube';

    public $providerId;
    public $provider;

    /**
     * @param $url
     * @return null|string
     */
    public function identifyProvider($url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidParamException('Param must be a valid url.');
        }

        foreach ($this->providers() as $id => $provider) {
            $pattern = $this->getProviderPattern($provider);
            if (preg_match($pattern, $url)) {
                return $id;
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
        $this->providerId = $this->identifyProvider($url);


        // Get video id
        $finder = new UrlFinder();
        $id = $finder->{$this->providerId}->find($url)->one()['id']['0'];

        // Get provider instance
        $this->provider = $this->getProviderInstance($this->providerId);

        return $this->provider->requestThumbnail($id);
    }
}