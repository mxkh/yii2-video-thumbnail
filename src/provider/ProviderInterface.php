<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 03.11.15
 * Time: 00:50
 */

namespace mxkh\VideoThumbnail\provider;

/**
 * Interface ProviderInterface
 * @package mxkh\VideoThumbnail\provider
 */
interface ProviderInterface
{
    public static function pattern();

    public function requestThumbnail($id);

    public function sizes();
}