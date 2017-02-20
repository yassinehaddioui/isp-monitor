<?php
/**
 * Created by -
 * User: yassinehaddioui
 * Date: 2/19/17
 * Time: 6:42 PM
 */

namespace IspMonitor\Services;


use Doctrine\Instantiator\Exception\InvalidArgumentException;
use IspMonitor\Interfaces\CacheProvider;

class CachingService implements CacheProvider
{
    /**
     * @var CacheProvider
     */
    protected $cacheProvider;

    /**
     * CachingService constructor.
     * @param CacheProvider $cacheProvider
     */
    public function __construct(CacheProvider $cacheProvider)
    {
        $this->cacheProvider = $cacheProvider;
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function get($key) {
        if (empty($key))
            throw new InvalidArgumentException('Key is needed');
        return $this->cacheProvider->get($key);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param int $ttl
     */

    public function set($key, $value, $ttl = 0) {
        if (empty($key))
            throw new InvalidArgumentException('Key is needed');
        if (empty($value))
            throw new InvalidArgumentException('Value cannot be empty.');
        return $this->cacheProvider->set($key, $value, $ttl);
    }

    /**
     * Deletes a cached entry if it exists.
     * @param array $keys
     * @return void
     */
    public function delete($keys) {
        $this->cacheProvider->delete($keys);
    }

}