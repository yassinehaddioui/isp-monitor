<?php
/**
 * Created by -
 * User: yassinehaddioui
 * Date: 2/12/17
 * Time: 3:26 PM
 */

namespace IspMonitor\Utilities;


class Environment
{
    private static $composerJson;
    const COMPOSER_PATH = __DIR__ . '/../../composer.json';

    /**
     * Returns the whole composer.json as an array
     * @return array
     */
    public static function getComposerJson()
    {
     if (!self::$composerJson && file_exists(static::COMPOSER_PATH))
     {
         self::$composerJson = json_decode(file_get_contents(static::COMPOSER_PATH), true) ?: [];
     }
        return self::$composerJson;
    }

    /**
     * Returns the version component of composer.json
     * @return string
     */

    public static function getPackageVersion(){
        if (!empty(static::getComposerJson()['version']))
            return static::getComposerJson()['version'];
        return '';
    }
}