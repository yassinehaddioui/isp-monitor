<?php
/**
 * Created by -
 * User: yassinehaddioui
 * Date: 12/28/16
 * Time: 11:12 PM
 */

namespace IspMonitor\Interfaces;


interface CacheProvider
{
    /**
     * Gets a cached value
     * @param string $key
     * @return mixed|null
     */
    public function get($key);

    /**
     * Sets a cache entry.
     * @param string $key
     * @param mixed $value
     * @param int $ttl
     * @return void
     */
    public function set($key, $value, $ttl = 0);

    /**
     * Deletes a cached entry if it exists.
     * @param array $keys
     * @return void
     */
    public function delete($keys);

}